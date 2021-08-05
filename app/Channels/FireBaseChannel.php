<?php

namespace App\Channels;

use App\Helpers\FCMHelper;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class FireBaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $subject = $notification->toSubject($notification);
        $data = $notification->toArray($notification);
        $message = $notification->toString($data);
        $created_at = Carbon::now();
        $date = $created_at->toFormattedDateString();
        $is_read = false;

        $notification->object["message"] = $message;
        $notification->object["date"] = $date;
        $notification->object["is_read"] = $is_read;

        $data = $notification->toObject($data);
        $tokens = $notifiable->firebase_tokens();

        if (count($tokens) > 0) {
            FCMHelper::Send_Downstream_Message_Multiple($tokens, $subject, $message, ["data" => $data]);
        }
    }
}
