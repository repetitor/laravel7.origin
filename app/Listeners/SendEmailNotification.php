<?php


namespace App\Listeners;


use App\Mail\UserRegistered;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


use App\Notifications\InvoicePaid;

class SendEmailNotification
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
////            $event->user->sendEmailVerificationNotification();
////            $this->notify(new VerifyEmail);
////            Mail::to('viktar202@gmail.com')->send((new VerifyEmail)->toMail($event->user));
//
////            (new VerifyEmail)->toMail($event->user);
//            $mmm = (new VerifyEmail)->toMail($event->user);
//            $actionUrl=$mmm->actionUrl;
//            $b=3;
////            Mail::to('viktar202@gmail.com')->send(new UserRegistered($event->user));
//            Mail::to('viktar202@gmail.com')->send(new UserRegistered($actionUrl));



//            $mmm = (new VerifyEmail)->toMail($event->user);
//            $actionUrl=$mmm->actionUrl;
//            Mail::to('viktar202@gmail.com')->send(new UserRegistered($actionUrl));


//            $mmm = (new InvoicePaid)->toMail($event->user);

//            Auth::user()->notify((new InvoicePaid('$invoice'))->locale('es'));
            User::firstWhere('email', '=', 'viktar202@ya.ru')->notify((new InvoicePaid('$invoice'))->locale('es'));
//            $actionUrl=$mmm->actionUrl;
//            Mail::to('viktar202@gmail.com')->send(new UserRegistered($actionUrl));



        }

//        Mail::to('viktar202@gmail.com')->send(new UserRegistered($event->user));
    }
}
