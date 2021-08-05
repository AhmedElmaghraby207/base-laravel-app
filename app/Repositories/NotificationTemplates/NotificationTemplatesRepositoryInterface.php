<?php

namespace App\Repositories\NotificationTemplates;


interface NotificationTemplatesRepositoryInterface
{
    public function get($id, $fail = true);

    public function list($with_get = true, array $param = []);

    public function update($id, array $template_array);
}
