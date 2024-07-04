<?php

namespace App\Jobs;

use App\Models\Issue_Myissue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class IssueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $post_content;
    protected $session_id;
    /**
     * Create a new job instance.
     */
    public function __construct($post_content, $session_id)
    {
        $this->post_content = $post_content;
        $this->session_id = $session_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Issue_Myissue::create_issue($this->post_content, $this->session_id);
        Cache::tags('issue_page')->flush();
    }
}
