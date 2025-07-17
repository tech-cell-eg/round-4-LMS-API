<?php
namespace App\Notifications;

use App\Events\NewReviewEvent;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

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
            'user_name' => $this->review->user->first_name . ' ' . $this->review->user->last_name,
            'user_image' => $this->review->user->image ? asset('storage/' . $this->review->user->image) : null,
            'reviewed_type' => class_basename($this->review->reviewable_type),
            'reviewed_id' => $this->review->reviewable_id,
            'reviewed_title' => $this->getReviewedTitle(),
            'created_at' => $this->review->created_at->diffForHumans(),
        ];
    }

    protected function getReviewedTitle()
    {
        if ($this->review->reviewable_type === Course::class) {
            return $this->review->reviewable->title;
        }

        if ($this->review->reviewable_type === Instructor::class) {
            return $this->review->reviewable->first_name . ' ' . $this->review->reviewable->last_name;
        }

        return null;
    }

    public function broadcastTo($notifiable): void
    {
        $data = $this->toArray($notifiable);

        $data['instructor_username'] = $notifiable->username;

        event(new NewReviewEvent($data));
    }
}
