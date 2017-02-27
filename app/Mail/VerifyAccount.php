<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;

class VerifyAccount extends Mailable
{
    /**
     * $link: secure link for activating account.
     * $user: registered user.
     * @var
     */
    public $link;
    public $user;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->link = $this->makeSecureLink();
    }

    /**
     * Create secure link for activating account.
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    protected function makeSecureLink()
    {
        $email = $this->user->email;
        $password = User::select('password')->where('email', $email)->first()->password;

        $hashedPass = bcrypt($password);
        $hashedEmail = base64_encode($email);
        $suffix = $hashedEmail . $hashedPass;

        return url('accountActive?key=' . $suffix);
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromAddress = config('mail.from')['address'];
        $name = config('mail.from')['name'];
        $subject = trans('auth.verify_account_subject');
        $content = [
            'user' => $this->user,
            'link' => $this->link
        ];

        return $this->view('auth.verifyAccount')->with($content)
            ->from($fromAddress, $name)
            ->subject($subject);
    }
}
