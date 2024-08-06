<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo(){
        $data['withdrawVerify'] = [
            'path'=>'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      =>'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      =>'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      =>'assets/images/user/profile',
            'size'      =>'350x300',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];

        $data['banner_one'] = [
            'path'      =>'assets/images/frontend/banner_one',
        ];
        $data['banner_two'] = [
            'path'      =>'assets/images/frontend/banner_two',
        ];

        $data['community'] = [
            'path'      =>'assets/images/frontend/community',
        ];

        $data['offer'] = [
            'path'      =>'assets/images/frontend/offer',
        ];

        $data['quality'] = [
            'path'      =>'assets/images/frontend/quality',
        ];

        $data['testimonial'] = [
            'path'      =>'assets/images/frontend/testimonial',
        ];

        $data['luxury'] = [
            'path'      =>'assets/images/frontend/luxury',
        ];

        $data['faq'] = [
            'path'      =>'assets/images/frontend/faq',
        ];

        $data['discover'] = [
            'path'      =>'assets/images/frontend/discover',
        ];

        $data['footer_gallery'] = [
            'path'      =>'assets/images/frontend/footer_gallery',
        ];

        $data['contact_us'] = [
            'path'      =>'assets/images/frontend/contact_us',
        ];

        $data['hostel'] = [
            'path'      =>'assets/images/backend/hostel',
            'size'      =>'856x505',
        ];

        $data['room'] = [
            'path'      =>'assets/images/backend/room',
            'size'      =>'415x245',
        ];
        $data['blog'] = [
            'path'      =>'assets/images/backend/blog',
            'size'      =>'805x450',
        ];
        $data['blog_post'] = [
            'path'      =>'assets/images/frontend/blog_post',
            'size'      =>'805x450',
        ];

        $data['community_post'] = [
            'path'      =>'assets/images/backend/community_post',
            'size'      =>'800x380',
        ];

        $data['shape'] = [
            'path'      =>'assets/images/frontend/shape',
        ];

        return $data;
	}

}
