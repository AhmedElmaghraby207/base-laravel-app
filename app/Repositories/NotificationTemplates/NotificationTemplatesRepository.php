<?php

namespace App\Repositories\NotificationTemplates;

use App\NotificationTemplate;
use App\Repositories\BaseRepository;

class NotificationTemplatesRepository extends BaseRepository implements NotificationTemplatesRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(NotificationTemplate::Query());
    }

    public function list($with_get = true, array $param = [])
    {
        $name = $param["name"] ?? null;
        $subject = $param["subject"] ?? null;

        $templates = $this->query()->where('name', '!=', 'P_Announcement');

        if ($name) {
            $templates = $templates->where('name', 'like', '%' . $name . '%');
        }

        if ($subject) {
            $templates = $templates->where('subject', 'like', '%' . $subject . '%');
        }

        if ($with_get) {
            $templates = $templates->get();
        }
        return $templates;
    }

}
