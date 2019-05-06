<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

class SendEmail extends Job
{
    protected $info;

    protected $view;

    protected $fields;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($info, $view, $fields)
    {
        $this->info = $info;
        $this->view = $view;
        $this->fields = $fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = is_array($this->info['email']) ? $this->info['email'] : [$this->info['email']];
        $subject = $this->info['subject'];
        Mail::send($this->view, $this->fields, function ($message) use ($emails, $subject) {
            $message->from(config('mail.from.address'));
            $message->to($emails)->subject($subject);
        });
    }
}
