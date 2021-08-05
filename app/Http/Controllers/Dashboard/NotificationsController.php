<?php

namespace App\Http\Controllers\Dashboard;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class NotificationsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('dashboard.notifications.index');
    }

    public function getNotifications(Request $request)
    {
        $subject_field = $request->subject;
        $message_field = $request->message;
        $res = [];

        $page = ($request->start / $request->length) + 1 ?: 1; /* Actual page */
        $limit = $request->length; /* Limit per page */

        $notifications = Notification::query()
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        if ($notifications->total() > 0) {
            foreach ($notifications as $notification) {
                $h = App::make($notification->type);
                $notification->data = json_decode($notification->data, JSON_FORCE_OBJECT);

                $message = $h->toString($notification->data);
                $subject = $h->toSubject($notification->data);
                $url = $h->toURL($notification->data);

                $is_read = ($notification->read_at != null);
                $data = $notification->data;
                $created_at = \Carbon\Carbon::parse($notification->created_at);
                $date = $created_at->toFormattedDateString();

                $h->object["id"] = $notification->id;
                $h->object["subject"] = $subject;
                $h->object["message"] = $message;
                $h->object["url"] = $url;
                $h->object["date"] = $date;
                $h->object["is_read"] = $is_read;

                $n = $h->toObject($notification->data);
                $n['created_at'] = $notification->created_at;

                if ($subject_field && $message_field) {
                    if ($subject_field == $n['subject'] && $message_field == $n['message']) {
                        $res[] = $n;
                    }
                } elseif ($subject_field && !$message_field) {
                    if ($subject_field == $n['subject']) {
                        $res[] = $n;
                    }
                } elseif (!$subject_field && $message_field) {
                    if ($message_field == $n['message']) {
                        $res[] = $n;
                    }
                } else {
                    $res[] = $n;
                }
            }

            $total = $notifications->total();
            $output = array(
                "draw" => $request->draw,
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $res,
                "subject" => $subject,
                "url" => $url,
                "MissionId" => $notification->data["MissionId"],
                "input" => []
            );
            return json_encode($output);
        } else {
            return datatables()->of($res)->toJson();
        }
    }

    public function unreadList()
    {
        $res = [];
        $unread = true;
        $unread_notifications = Notification::where('read_at', '=', null)->get();
        foreach ($unread_notifications as $notification) {

            $h = App::make($notification->type);
            $notification->data = json_decode($notification->data, JSON_FORCE_OBJECT);

            $message = $h->toString($notification->data);
            $subject = $h->toSubject($notification->data);
            $url = $h->toURL($notification->data);

            $is_read = ($notification->read_at != null);
            $data = $notification->data;
            $created_at = \Carbon\Carbon::parse($notification->created_at);
            $date = $created_at->diffForHumans();

            $h->object["id"] = $notification->id;
            $h->object["subject"] = $subject;
            $h->object["message"] = $message;
            $h->object["url"] = $url;
            $h->object["date"] = $date;
            $h->object["is_read"] = $is_read;

            $res[] = $h->toObject($notification->data);
        }

        return $res;
    }

    public function markAsRead()
    {
        $notifications = Notification::all()->where('read_at', '=', null);

        foreach ($notifications as $notification) {
            $notification->read_at = date("Y-m-d H:i:s");
            $notification->save();
        }
    }

    public function destroy($id)
    {
        $deleted_notification = Notification::find($id)->delete();

        if ($deleted_notification) {
            session()->flash('success_message', trans('main.deleted_alert_message', ['attribute' => Lang::get('notification.attribute_name')]));
            return redirect()->route('notification.index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
