<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Notification\GoogleNotification;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * list of require data for sending notification.
     */
    public array $options;

    /**
     * Create a new job instance.
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new GoogleNotification())->send($this->options);
    }
}
