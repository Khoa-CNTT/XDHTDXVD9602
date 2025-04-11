<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mailQuenMatKhau extends Mailable
{
    use Queueable, SerializesModels;
    
    public $info;

    public function __construct($info)
    {
        $this->info     = $info;
    }

    public function build()
    {
        return $this->subject('Khôi Phục Tài Khoản Của Bạn')
                    ->view('mail.quen_mat_khau', ['info' => $this->info]);
    }
}
