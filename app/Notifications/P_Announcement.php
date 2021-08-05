<?php

namespace App\Notifications;

use App\Channels\FireBaseChannel;
use App\NotificationTemplate;
use App\Setting;
use Illuminate\Support\Facades\Config;

class P_Announcement extends _BaseNotification
{
    public $patient;
    public $subject;
    public $content;
    public $subject_en;
    public $subject_ar;
    public $content_en;
    public $content_ar;

    public function __construct($patient = null, $subject_en = null, $subject_ar = null, $content_en = null, $content_ar = null)
    {
        parent::__construct('P_Announcement');

        $this->patient = $patient;
        $this->subject_en = $subject_en;
        $this->subject_ar = $subject_ar;
        $this->content_en = $content_en;
        $this->content_ar = $content_ar;
        $this->template = NotificationTemplate::where('name', $this->template_Name)->first();

        if ($this->patient->lang == 'ar') {
            $this->subject = $this->subject_ar;
            $this->content = $this->content_ar;
        } else {
            $this->subject = $this->subject_en;
            $this->content = $this->content_en;
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
            'subject_en' => $this->subject_en,
            'subject_ar' => $this->subject_ar,
            'content_en' => $this->content_en,
            'content_ar' => $this->content_ar,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'subject_en' => $this->subject_en,
            'subject_ar' => $this->subject_ar,
            'content_en' => $this->content_en,
            'content_ar' => $this->content_ar,
        ];
    }

    public function toSubject($data)
    {
        $template = $this->template;
        if (empty($template))
            return '';

        $dataObject = $this->reloadDataObject($data);

        $res = view('template.P_Announcement_subject', [
            "subject" => $dataObject['subject'],
        ])->render();

        return trim($res);
    }

    public function toString($data)
    {
        $template = $this->template;
        if (empty($template))
            return '';

        $dataObject = $this->reloadDataObject($data);

        $res = view('template.P_Announcement_content', [
            "content" => $dataObject['content']
        ])->render();

        return trim($res);
    }

    public function reloadDataObject($data)
    {
        $data = (object)$data;
        if ($this->dataObject == []) {
            if ($this->patient->lang == 'ar') {
                $this->dataObject['subject'] = $data->subject_ar;
                $this->dataObject['content'] = $data->content_ar;
            } else {
                $this->dataObject['subject'] = $data->subject_en;
                $this->dataObject['content'] = $data->content_en;
            }
        }
        return $this->dataObject;
    }

    public function toObject($data)
    {
        $dataObject = $this->reloadDataObject($data);

        $res = $this->object;
        $res['subject'] = $dataObject['subject'];
        $res['content'] = $dataObject['content'];
        $res['entity_id'] = Config::get('constants.ENTITY_ID_Announcement');
        $res['thumbnail'] = url(Setting::where('key', 'announcement_notification_image')->first()->value);
        return $res;
    }
}
