<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Rider;
use App\Models\Notification;
use App\Models\NotificationUser;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notif = NotificationUser::query();
        if ($request->has('rider_id') && $request->filled('rider_id')) {
            $notif->where('rider_id', $request->rider_id);

        }
        $notif->with(['notif']);
        $notif->orderBy('id', 'DESC');
        return api_success('Notifications of riders', $notif->paginate(10));
    }

    public function store(Request $request)
    {
        $notif = new Notification;
        $notif->notification_id = Str::uuid();
        $notif->heading = $request->heading;
        $notif->text = $request->text;

        if ($request->type == "single_region") $notif->region_id = $request->region_id;

        if ($notif->save()) {
            if ($request->type == "single_rider") {
                $rider = Rider::where('rider_id', $request->rider_id)->where('device_token', '!=', NULL)->where('device_token', '!=', '')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->first();
                
                $notif_user = new NotificationUser;
                $notif_user->notification_user_id = Str::uuid();
                $notif_user->notification_id = $notif->notification_id;
                $notif_user->rider_id = $rider->rider_id;
                $notif_user->save();
                $device_tokens[] = $rider->device_token;


            } else if ($request->type == "all_riders") {
                $riders = Rider::where('device_token', '!=', NULL)->where('device_token', '!=', '')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->get();
                $device_tokens = array();

                foreach($riders as $key => $value) {
                    $notif_user = new NotificationUser;
                    $notif_user->notification_user_id = Str::uuid();
                    $notif_user->notification_id = $notif->notification_id;
                    $notif_user->rider_id = $value->rider_id;
                    $notif_user->save();
                    $device_tokens[] = $value->device_token;
                }

            } else if ($request->type == 'single_region') {
                $riders = Rider::where('region_id', $notif->region_id)->where('device_token', '!=', NULL)->where('device_token', '!=', '')->whereRaw('`flags` & ?=?', [Rider::FLAG_ACTIVE, Rider::FLAG_ACTIVE])->get();
                $device_tokens = array();
                foreach($riders as $key => $value) {
                    $notif_user = new NotificationUser;
                    $notif_user->notification_user_id = Str::uuid();
                    $notif_user->notification_id = $notif->notification_id;
                    $notif_user->rider_id = $value->rider_id;
                    $notif_user->save();
                    $device_tokens[] = $value->device_token;

                }
            }

            if (!empty($device_tokens)) {
                $result = $this->sendPushNotification($device_tokens, $notif->heading, $notif->text);
            }
        }
        return api_success1('Notification Send Successfully!');
    }

    public function update (Request $request, $id)
    {
        $notif = NotificationUser::where('notification_user_id', $id)->first();
        $notif->removeFlag(NotificationUser::FLAG_READ);
        $notif->addFlag(NotificationUser::FLAG_READ);
        if ($notif->save()) return api_success1('Notification Status Updated!');

        return api_error();
    }

    public function sendPushNotification($tokens = [], $title, $message)
    {
        $data = array();
        $data = [
            "registration_ids" => $tokens,
            "data" => [
                "title" => $title,
                "body" => $message,
                "icon" => url('public/assets/img/herbapkalogo.png'),
            ],
            "notification" => [
                "title" => $title,
                "body" => $message,
                "icon" => url('public/assets/img/herbapkalogo.png'),
            ],
        ];
        return notification_core($data);
    }
}
