<?php

namespace App\Helpers;

use App\Models\Setting;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;

class FCMHelper
{

    public static function Send_Downstream_Message($token, $title, $mess, $data = [])
    {
        $key = Setting::where("key", '=', "FCM_SERVER_KEY")->first();
        if ($key) {
            $server_key = $key->value;
            $client = new Client();
            $client->setApiKey($server_key);
            $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

            $message = new Message();
            $message->setPriority('high');
            $message->addRecipient(new Device($token));
            $message->setNotification(new Notification($title, $mess))->setData($data);

            $response = $client->send($message);
        }
    }

    public static function Send_Downstream_Message_Multiple($tokens, $title, $mess, $data = [])
    {
        $key = Setting::where("key", '=', "FCM_SERVER_KEY")->first();
        if ($key) {
            $server_key = $key->value;
            $client = new Client();
            $client->setApiKey($server_key);
            $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
            $message = new Message();
            $message->setPriority('high');
            foreach ($tokens as $key => $token) {
                if ($token != null) {
                    $message->addRecipient(new Device($token));
                }
            }
            if ($title != null) {
                $message->setNotification(new Notification($title, $mess));
            }
            $message->setData($data);
            $response = $client->send($message);
        }
    }

    public static function Subscribe_User_To_FireBase_Topic($topic_id, $array_firebase_tokens)
    {
        $key = Setting::where("key", '=', "FCM_SERVER_KEY")->first();
        if ($key) {
            $server_key = $key->value;
            $client = new Client();
            $client->setApiKey($server_key);
            $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
            $response = $client->addTopicSubscription($topic_id, $array_firebase_tokens);
        }
    }

    public static function Send_Notification_To_FireBase_Topic($topic_id, $title, $body)
    {
        $key = Setting::where("key", '=', "FCM_SERVER_KEY")->first();
        if ($key) {
            $server_key = $key->value;
            $client = new Client();
            $client->setApiKey($server_key);
            $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
            // $response = $client->addTopicSubscription($topic_id, $array_firebase_tokens);

            $message = new Message();
            $message->setPriority('high');
            $message->addRecipient(new Topic($topic_id));
            $message->setNotification(new Notification($title, $body))->setData(['key' => 'value']);
            $response = $client->send($message);
        }
    }

}
