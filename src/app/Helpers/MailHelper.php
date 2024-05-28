<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class MailHelper
{
    // 
    public static function sendMailVerifyTracker($data = null){
        Mail::send('mail.contact', $data, function($message) use ($data){
            $message->to($data['email_customer'], 'Customer');
            $message->replyTo($data['email_reply'], 'Reply');
            $message->subject($data['subject']);
        });
        return true;
    }
    
}
