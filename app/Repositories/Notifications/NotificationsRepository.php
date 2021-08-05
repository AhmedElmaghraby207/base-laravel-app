<?php

namespace App\Repositories\Notifications;

use App\Notification;
use App\Repositories\BaseRepository;

class NotificationsRepository extends BaseRepository implements NotificationsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Notification::Query());
    }

    public function list($with_get = true, array $param = [])
    {
        $unread = $param["unread"] ?? null;

        $notifications = $this->query();

        if ($unread) {
            $notifications = $notifications->where('read_at', '=', null);
        }

        $notifications = $notifications->get();
        return $notifications;
    }

    public function markAsRead($id)
    {
        $notifications = $this->query();
        $notifications = $notifications->where('id', $id)->update(['read_at' => date("Y-m-d H:i:s")]);

        return $notifications;
    }

}
