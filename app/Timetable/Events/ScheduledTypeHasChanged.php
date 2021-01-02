<?php

namespace App\Timetable\Events;

use App\Models\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduledTypeHasChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Course
     */
    private $course;

    /**
     * @var array
     */
    private $previousAttribute;

    /**
     * @var array
     */
    private $currentAttribute;

    /**
     * Create a new event instance.
     *
     * @param Course $course
     * @param array $previousAttribute
     * @param array $currentAttribute
     */
    public function __construct(Course $course, array $previousAttribute, array $currentAttribute)
    {
        $this->course = $course;

        $this->previousAttribute = $previousAttribute;

        $this->currentAttribute = $currentAttribute;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
