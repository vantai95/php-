<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Configuration;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSendAdmin extends Mailable
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
        $email_admin = Configuration::where('config_key', 'EMAIL_ADMIN_RECEIVED')->first()->config_value;

        $msgSalutation = trans('b2c.email_send_admin.salutation');

        $email_header = trans('b2c.email_send_admin.header');
        $msgHeader = str_replace('$email', $request->get('email'), $email_header);

        $email_content = trans('b2c.email_send_admin.content');
        $msgContent = str_replace('$content', $request->get('content'), $email_content);

        $msgFooter = trans('b2c.email_send_admin.footer');

        $msgClosing = trans('b2c.email_send_admin.closing');

        $msgSignature = trans('b2c.email_send_admin.signature');
        return $this->view('emails.email_send_admin',
                            [    'salutation' => $msgSalutation,
                                 'header' => $msgHeader,
                                 'content' => $msgContent,
                                 'footer' => $msgFooter,
                                 'closing' => $msgClosing,
                                 'signature' => $msgSignature])
                    ->to($email_admin);
    }
}
