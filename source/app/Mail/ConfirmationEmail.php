<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $msgHeader = trans('b2c.email_message.header');
        $msgBody = trans('b2c.email_message.body');
        $msgFooter = trans('b2c.email_message.footer');
        return $this->view('emails.email', ['header' => $msgHeader, 'body' => $msgBody, 'footer' => $msgFooter, 'full_name' => $request->name ])
            ->to($request->email);
    }
}
