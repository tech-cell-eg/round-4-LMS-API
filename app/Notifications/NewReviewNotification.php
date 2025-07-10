<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $review;

    public function __construct($review)
    {
        $this->review = $review;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'rating' => $this->review->rating,
            'comment' => $this->review->comment,
            'user_name' => $this->review->user->name,
            'reviewed_type' => class_basename($this->review->reviewable_type),
            'reviewed_id' => $this->review->reviewable_id,
        ];
    }
}
