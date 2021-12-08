<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Rejection;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function emitNotification($titulos, $contenido, Product $product, $users_ids, $comment)
    {
        $headings = array(
            "en" => $titulos['es'],
            "es" => $titulos['es'],
        );

        $content = array(
            "en" => $contenido['es'],
            "es" => $contenido['es']
        );

        $fields = array(
            'app_id' => "67b993d9-0c0b-4af5-ba28-41d92295f1d5",
            // 'included_segments' => array('All'),
            'data' => array(
                "product_id" => $product->id,
                "status" => $product->status,
                "comments" => $comment
            ),
            // 'small_icon' =>"https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/WhatsApp_icon.png/239px-WhatsApp_icon.png",
            'contents' => $content,
            'headings' => $headings,
            "include_external_user_ids" => $users_ids
        );

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YmU3OGQ3NjQtYzAwMS00MTNjLWIxNjUtNjg0MThkYmE3MThl'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function triggerNotification($titulos, $contenido, Product $product, $users_ids, $comment)
    {
        $response = $this->emitNotification($titulos, $contenido, $product, $users_ids, $comment);
        $return["allresponses"] = $response;
        $return = json_encode($return);
    }

    public function getAllNotificationsById(Request $request)
    {
        $notifications = Notification::where('user_id', $request->input('user_id'))
            ->limit(70)
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($notifications as $notification) {
            $product = Product::where('id', $notification->product_id)->first();
            $notification->image_url = null;
            $notification->product_name = null;
            $notification->product_slug = null;
            if ($notification->product_id) {
                if ($product) {
                    $notification->image_url = $product->images()->count() ? $product->images()->first()->url : 'images/image-not-found.png';
                    $notification->product_name = $product->name;
                    $notification->product_slug = $product->slug;
                }
            }
        }

        return $notifications;
    }

    public function getNotificationsById(Request $request)
    {
        $notifications = Notification::where('user_id', $request->input('user_id'))
            ->where('read', false)
            ->limit(70)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($notifications as $notification) {
            $product = Product::where('id', $notification->product_id)->first();
            $notification->image_url = null;
            $notification->product_name = null;
            $notification->product_slug = null;
            if ($notification->product_id) {
                if ($product) {
                    $notification->image_url = $product->images()->count() ? $product->images()->first()->url : 'images/image-not-found.png';
                    $notification->product_name = $product->name;
                    $notification->product_slug = $product->slug;
                }
            }
        }

        return $notifications;
    }

    public function readNotifications(Request $request)
    {
        Notification::where('user_id', $request->input('user_id'))
            ->where('read', false)
            ->update([
                'read' => true
            ]);
        return json_encode('Notificaciones leidas');
    }

    public function readNotification(Request $request)
    {
        Notification::where('id', $request->input('id'))
            ->update(['read' => true]);

        return json_encode('Notificacion leida');
    }
}
