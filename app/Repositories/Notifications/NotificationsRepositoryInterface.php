<?php

namespace App\Repositories\Notifications;

interface NotificationsRepositoryInterface
{
    public function get($id, $fail = true);

    public function list($with_get = true, array $param = []);

    public function markAsRead($id);

    public function delete($id);
}
