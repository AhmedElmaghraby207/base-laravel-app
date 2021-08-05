<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class _BaseNotification extends Notification
{
    use Queueable;

    protected $template_Name;
    protected $template;

    public function __construct($template_Name)
    {
        $this->template_Name = $template_Name;
    }

    public $dataObject = [];
    public $object = [
        "date" => null,
        "is_read" => null,

        "popup" => 0,
        "popup_image" => "",

        "entity_id" => null,
    ];
}
