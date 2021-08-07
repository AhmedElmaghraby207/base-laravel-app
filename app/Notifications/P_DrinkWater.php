<?php

namespace App\Notifications;

use App\Channels\FireBaseChannel;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class P_DrinkWater extends _BaseNotification
{
    public $patient;
    public $subject;
    public $content;

    public function __construct($patient = null)
    {
        parent::__construct('P_DrinkWater');
        $this->template = NotificationTemplate::where('name', $this->template_Name)->first();

        $this->patient = $patient;
        if ($this->patient->lang == 'ar') {
            $this->subject = $this->template->subject_ar;
            $this->content = $this->template->template_ar;
        } else {
            $this->subject = $this->template->subject_en;
            $this->content = $this->template->template_en;
        }
    }

    public function via($notifiable)
    {
        return [
            'database',
            FireBaseChannel::class
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'subject' => $this->subject,
            'content' => $this->content,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'content' => $this->content,
        ];
    }

    public function toSubject($data)
    {
        return $this->subject;
    }

    public function toString($data)
    {
        return $this->content;
    }

    public function toObject($data)
    {
        $res = $this->object;
        $res['subject'] = $this->subject;
        $res['content'] = $this->content;
        $res['entity_id'] = Config::get('constants.ENTITY_ID_DrinkWater');
        $res['thumbnail'] = url(Setting::where('key', 'drink_water_notification_image')->first()->value);
        return $res;
    }
}
