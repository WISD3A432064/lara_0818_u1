<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function getSend(){
        $content='xxxxxxxxxxxxx';
        $data = ['name' => '張三', 'content'=> $content, ];
        Mail::send('enail.test', $data, function($message){
            $message->subject('Laravel 5 Mail');
            $message->to('poikl15397@gmail.com', '張三');
            $message->from('netadmin@ncut.edu.tw', 'netadmin');
        });

    }
}
