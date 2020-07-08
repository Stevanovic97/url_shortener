<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $short;
    protected $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($short, $detail)
    {
        $this->short = $short;
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')->withShort($this->short)->withDetail($this->detail);
    }
}
