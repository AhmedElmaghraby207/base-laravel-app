<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

//Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(trans('dashboard.title'), url('/dashboard'));
});

//***************************************************************
// Dashboard > Admins
Breadcrumbs::for('admins', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin.title_list'), route('admin.index'));
});

// Dashboard > Admins > Create
Breadcrumbs::for('admins-create', function ($trail) {
    $trail->parent('admins');
    $trail->push(trans('admin.title_create'), route('admin.create'));
});

// Dashboard > Admins > Edit
Breadcrumbs::for('admins-edit', function ($trail, $id) {
    $trail->parent('admins');
    $trail->push(trans('admin.title_edit'), route('admin.edit', $id));
});

// Dashboard > Admins > Show
Breadcrumbs::for('admins-show', function ($trail, $id) {
    $trail->parent('admins');
    $trail->push(trans('admin.title_show'), route('admin.show', $id));
});

//***************************************************************
// Dashboard > notification_template > list
Breadcrumbs::for('notification_templates', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('notification_template.title_list'), route('notification_template.list'));
});
// Dashboard > notification_template > Edit
Breadcrumbs::for('notification_template-edit', function ($trail, $id) {
    $trail->parent('notification_templates');
    $trail->push(trans('notification_template.title_edit'), route('notification_template.edit', $id));
});

//***************************************************************
// Dashboard > Patients
Breadcrumbs::for('patients', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('patient.title_list'), route('patient.index'));
});

// Dashboard > Patients > Create
Breadcrumbs::for('patients-create', function ($trail) {
    $trail->parent('patients');
    $trail->push(trans('patient.title_create'), route('patient.create'));
});

// Dashboard > Patients > Edit
Breadcrumbs::for('patients-edit', function ($trail, $id) {
    $trail->parent('patients');
    $trail->push(trans('patient.title_edit'), route('patient.edit', $id));
});

// Dashboard > Patients > show
Breadcrumbs::for('patients-show', function ($trail, $id) {
    $trail->parent('patients');
    $trail->push(trans('patient.title_show'), route('patient.show', $id));
});

//***************************************************************
// Dashboard > Announcements > Create
Breadcrumbs::for('announcements-create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('announcement.title_create'), route('announcement.create'));
});

//***************************************************************
// Dashboard > Settings
Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('setting.title_list'), route('setting.index'));
});

// Dashboard > Settings > Edit
Breadcrumbs::for('settings-edit', function ($trail, $id) {
    $trail->parent('settings');
    $trail->push(trans('setting.title_edit'), route('setting.edit', $id));
});

//***************************************************************
// Dashboard > Roles
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('role.title_list'), route('role.index'));
});

// Dashboard > roles > Create
Breadcrumbs::for('roles-create', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('role.title_create'), route('role.create'));
});

// Dashboard > roles > Edit
Breadcrumbs::for('roles-edit', function ($trail, $id) {
    $trail->parent('roles');
    $trail->push(trans('role.title_edit'), route('role.edit', $id));
});

// Dashboard > roles > show
Breadcrumbs::for('roles-profile', function ($trail, $id) {
    $trail->parent('roles');
    $trail->push(trans('role.title_show'), route('role.show', $id));
});
