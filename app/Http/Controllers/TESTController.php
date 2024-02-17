<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;

class TESTController extends Controller
{
    public function test_send_email()
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('pradanafitrah45@gmail.com')->send(new DemoMail($mailData));

        dd("Email is sent successfully.");
    }

    public function phising()
    {
        return view('ITManagement.phising.index');
    }
}
