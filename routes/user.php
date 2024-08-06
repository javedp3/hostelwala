<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user/data', 'User\UserController@userData')->name('data');
        Route::post('user/data/submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {
            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');

                Route::get('booking-details', 'booking_list')->name('booking.list');

                Route::name('room.')->group(function () {
                    Route::get('room-details', 'room_list')->name('list');
                    Route::get('add-room', 'add_room')->name('add');
                });

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');
                //Report
                Route::any('payment/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            });

            // Hostel
            Route::controller('HostelController')->middleware('kyc')->name('hostel.')->group(function () {
                Route::get('hostel-details', 'hostel_list')->name('list');
                Route::get('add-hostel', 'add_hostel')->name('add');
                Route::post('store', 'store')->name('store');
                Route::get('hostel-edit/{id}', 'edit')->name('edit');
                Route::put('hostel-update/{id}', 'update')->name('update');
                Route::get('hostel-delete/{id}', 'delete')->name('delete');
                Route::post('image-delete', 'hostelImageDelete')->name("image.delete");
            });

            // Reviews
            Route::controller('ReviewController')->name('reviews.')->group(function () {
                Route::post('review-store', 'reviewStore')->name('store');
            });

            // Community
            Route::controller('CommunityController')->name('community.')->group(function () {
                Route::post('community-store', 'communityStore')->name('store');
                Route::get('community-edit/{id}', 'communityEdit')->name('edit');
                Route::put('community-update/{id}', 'communityUpdate')->name('update');
                Route::get('community-delete/{id}', 'communityDelete')->name('delete');
                Route::post('community-like', 'communityLike')->name('like');
                Route::post('community-comment-store', 'communityCommentStore')->name('comment.store');
                Route::post('comment-like', 'commentLike')->name('comment.like');
            });

            // Room
            Route::controller('RoomController')->middleware('kyc')->name('room.')->group(function () {
                Route::get('room-lists/{hostel_id}', 'room_list')->name('list');
                Route::get('add-room/{hostel_id}', 'add_room')->name('add');
                Route::post('room-store', 'store')->name('store');
                Route::get('room-edit/{hostel_id}/{room}', 'edit')->name('edit');
                Route::put('room-update/{hostel_id}/{room}', 'update')->name('update');
                Route::get('room-delete/{hostel_id}/{room}', 'delete')->name('delete');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });


            //Wishlist 
            Route::controller('wishlistController')->group(function () {
                Route::get('wishlist', 'wishlist_list')->name('wishlist.list');
                Route::post('wishlist', 'store')->name('wishlist');
                Route::get('wishlist-delete/{id}', 'delete')->name('wishlist.delete');

            });


            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::get('/', 'withdrawMoney');
                Route::post('/', 'withdrawStore')->name('.money');
                Route::get('preview', 'withdrawPreview')->name('.preview');
                Route::post('preview', 'withdrawSubmit')->name('.submit');
                Route::get('history', 'withdrawLog')->name('.history');
            });

            //KYC
            Route::controller('UserController')->group(function () {
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');
            });

            //Booking Controller
            Route::controller('BookingController')->name('booking.')->group(function () {
                Route::get('/booking-list', 'bookingList')->name('list');
                Route::get('/my-booked', 'myBooked')->name('my.booked');
                Route::post('/booking-preview', 'bookingPreview')->name('preview');
                Route::post('/booking-delete', 'bookingDelete')->name('delete');
                Route::get('/booking-now', 'bookingNow')->name('now');
                Route::post('/coupon-apply', 'couponApply')->name('coupon.apply');
            });
        });

        // Payment
        Route::middleware('registration.complete')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/payment', 'deposit')->name('deposit');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('payment/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });
});
