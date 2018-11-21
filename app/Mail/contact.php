<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contact extends Mailable
{
    use Queueable, SerializesModels;
public $demo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('dot@express.com');
}
