<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LeaveRequestStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rollno;
    public $status;

    public function __construct($rollno, $status)
    {
        $this->rollno = $rollno;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('student.' . $this->rollno);
    }

    public function broadcastWith()
    {
        return ['status' => $this->status];
    }
}
