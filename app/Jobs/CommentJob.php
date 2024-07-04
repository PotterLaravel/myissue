<?php

namespace App\Jobs;

use App\Models\Issue_Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $creator_id;
    protected $issue_id;
    protected $comment;
    /**
     * Create a new job instance.
     */
    public function __construct($issue_id, $creator_id, $comment)
    {
        $this->creator_id = $creator_id;
        $this->issue_id = $issue_id;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Issue_Comment::create_comment($this->issue_id, $this->creator_id, $this->comment);
        Cache::tags('comment_page')->flush();
    }
}
