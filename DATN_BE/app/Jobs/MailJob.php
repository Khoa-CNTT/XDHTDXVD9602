<?php

namespace App\Jobs;

use App\Mail\mailQuenMatKhau;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $info;
    /**
     * Create a new job instance.
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->info['email'])->send(new mailQuenMatKhau($this->info));
    }
}
