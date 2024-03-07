<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send example email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Menjalankan query INSERT menggunakan Query Builder
        DB::table('employees')->insert([
            'absentno' => 'John Doe',
            'empname' => 'john@example.com',
            'empemail' => 'john@example.com',
        ]);

        $mailData = [
            'email' => "pradanafitrah45@gmail.com",
            'title' => 'Otomatic Email Insurance',
            'body' => 'This is for testing email Every 15 Second'
        ];

        Mail::send('emails.demoMailAutomatic', $mailData, function ($message) use ($mailData) {
            $message->from('noreply@sl-maritime.com', 'Insurance Monitoring');

            $message->to($mailData["email"], $mailData["email"])
                ->subject($mailData["title"]);
        });
        dd("Email is sent successfully.");
    }
}
