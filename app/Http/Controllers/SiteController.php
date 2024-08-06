<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Hostel;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Wishlist;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        if (empty($reference)) {
            session()->forget('reference');
        }

        if ($request->search || $request->check_in || $request->check_out) {
            $pageTitle = 'Hostels';
            $request->validate([
                'search' => 'required',
                'check_in' => 'required',
                'check_out' => 'required'
            ]);

            $check_in = Carbon::parse($request->check_in);
            $check_out = Carbon::parse($request->check_out);

            if ($check_in <= now()) {
                $notify[] = ['error', 'Your check in date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_out < now()) {
                $notify[] = ['error', 'Your check out date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_in > $check_out) {
                $notify[] = ['error', 'Your check out date smaller then check in date'];
                return back()->withNotify($notify);
            }

            $hostels = Hostel::with('hostel_images', 'rooms', 'wishlist')->where('address', 'like', "%$request->search_show%")->where('status', 1)->paginate(getPaginate());
            return view($this->activeTemplate . 'hostel.hostel-list', compact('pageTitle', 'hostels'));
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function location_search(Request $request)
    {
        $pageTitle = 'Search Hostel';
        $hostels = Hostel::where('address', 'like', "%$request->search%")->get();
        $data = [
            'status' => "success",
            'hostel' => $hostels,
        ];
        return response()->json($data);
    }

    public function community()
    {
        $pageTitle = 'Community';
        $communities = Community::with('user', 'community_likes', 'comments')->orderBy('id', 'desc')->where('status', 1)->paginate(getPaginate());
        return view($this->activeTemplate . 'community.community', compact('pageTitle', 'communities'));
    }

    public function communitySearch(Request $request)
    {
        $communities = Community::where('title', 'like', "%$request->search%")->get();
        $data = [
            'status' => "success",
            'communities' => $communities,
        ];
        return response()->json($data);
    }

    public function communityDetails($id)
    {
        $pageTitle = 'Details';
        $community = Community::with('user', 'community_likes')->findOrFail($id);
        $community->view += 1;
        $community->save();
        $comments = Comment::with('user', 'comment_likes')->where('community_id', $id)->where('status', 1)->paginate(getPaginate(10));
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'community')->firstOrFail();
        $communities = Community::with('user')->orderBy('id', 'desc')->where('status', 1)->paginate(getPaginate());
        return view($this->activeTemplate . 'community.community_details', compact('pageTitle', 'community', 'sections', 'communities', 'comments'));
    }

    public function blog_post()
    {
        $pageTitle = 'Blog';
        $blogs = Frontend::where('data_keys', 'blog_post.element')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(6));
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        return view($this->activeTemplate . 'blog.blog_post', compact('pageTitle', 'blogs', 'sections'));
    }

    public function blog_details($id)
    {
        $pageTitle = 'Blog Details';
        $blogItem = Frontend::where('id', $id)->first();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        return view($this->activeTemplate . 'blog.blog_details', compact('pageTitle', 'blogItem', 'sections'));
    }

    public function hostel_list(Request $request)
    {
        $pageTitle = 'Hostels';
        if ($request->search || $request->check_in || $request->check_out) {
            $request->validate([
                'search' => 'required',
                'check_in' => 'required',
                'check_out' => 'required'
            ]);

            $check_in = Carbon::parse($request->check_in);
            $check_out = Carbon::parse($request->check_out);

            if ($check_in <= now()) {
                $notify[] = ['error', 'Your check in date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_out <= now()) {
                $notify[] = ['error', 'Your check out date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_in > $check_out) {
                $notify[] = ['error', 'Your check out date smaller then check in date'];
                return back()->withNotify($notify);
            }

            $hostels = Hostel::with('hostel_images', 'rooms', 'wishlist')->whereHas('rooms', function ($q) {
                $q->where('status', 1);
            })->where('address', 'like', "%$request->search_show%")->where('status', 1)->paginate(getPaginate());
        } else {
            $hostels = Hostel::with('hostel_images', 'rooms', 'wishlist')->whereHas('rooms', function ($q) {
                $q->where('status', 1);
            })->where('status', 1)->paginate(getPaginate());
        }
        return view($this->activeTemplate . 'hostel.hostel-list', compact('pageTitle', 'hostels'));
    }

    public function hostel_list_details(Request $request, $name, $id)
    {

        Session::forget("booking");
        Session::forget("coupon");
        $hostel = Hostel::with('hostel_images', 'rooms.bookings', 'reviews', 'user', 'wishlist')->where('id', $id)->where('status', 1)->first();
        $pageTitle = $hostel->name;
        $wishlist = Wishlist::where('hostel_id', $id)->where('user_id', auth()->id())->first();

        $reviews = Review::with('user')->where('hostel_id', $id)->paginate(getPaginate());
        $totalRating = $reviews->sum('rating');
        if ($request->search || $request->check_in || $request->check_out) {
            $request->validate([
                'search' => 'required',
                'check_in' => 'required',
                'check_out' => 'required'
            ]);

            $check_in = Carbon::parse($request->check_in);
            $check_out = Carbon::parse($request->check_out);

            if (!$check_in > now()) {
                $notify[] = ['error', 'Your check in date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_out < now()) {
                $notify[] = ['error', 'Your check out date smaller then current date'];
                return back()->withNotify($notify);
            } elseif ($check_in > $check_out) {

                $notify[] = ['error', 'Your check out date smaller then check in date'];
                return back()->withNotify($notify);
            }
        } else {
            $check_in = showDateTime(now()->addDay(1), 'm/d/Y');
            $check_out = showDateTime(now()->addDay(2), 'm/d/Y');
            $request->merge([
                'search' => $hostel->id,
                'search_show' => $hostel->address,
                'check_in' => $check_in,
                'check_out' => $check_out,
            ]);
        }

        if (!($hostel->rooms->count() > 0)) {
            $notify[] = ['warning', 'At first add rooms in your hostel'];
            return back()->withNotify($notify);
        } elseif (!$hostel->status === 1) {
            $notify[] = ['error', 'Your hostel is not valid'];
            return back()->withNotify($notify);
        }

        return view($this->activeTemplate . 'hostel.hostel-list-details', compact('pageTitle', 'hostel', 'reviews', 'totalRating', 'wishlist'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle'));
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
