<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function emitNotification()
    {
        $headings = array(
            "es"=> "Producto aprobado", 
            "en"=>"Su producto fue aprobado",
        );

        $content = array(
            "en" => 'Aproved Product',
            "es" => 'Su producto ha sido aprobado para ser publicado en la plataforma SaldoHVAC'
            );
    
        $fields = array(
            'app_id' => "67b993d9-0c0b-4af5-ba28-41d92295f1d5",
            'included_segments' => array('All'),
            'data' => array(
                "product_id"=> 374,
                "status" => "rejected",
                "comments" => "Su producto fue aprobado y ya se encuentra publicado"
            ),
            'small_icon' =>"https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/WhatsApp_icon.png/239px-WhatsApp_icon.png",
            'contents' => $content,
            'headings' => $headings,
            "include_external_user_ids" => ["6"]
        );
    
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic YmU3OGQ3NjQtYzAwMS00MTNjLWIxNjUtNjg0MThkYmE3MThl'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
    }
    
    public function triggerNotification(){
        $response = $this->emitNotification();
        $return["allresponses"] = $response;
        $return = json_encode( $return);
        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }

    public function getAllNotificationsById(Request $request){
        return Notification::where('user_id', $request->input('user_id'))->limit(70)->orderBy('created_at', 'desc')->get();
    }

    public function getNotificationsById(Request $request){
        return Notification::where('user_id', $request->input('user_id'))
                ->where('read', false)
                ->limit(70)
                ->orderBy('created_at', 'desc')
                ->get();
    }

    public function readNotifications(Request $request){
        Notification::where('user_id', $request->input('user_id'))
                ->where('read', false)
                ->update([
                    'read' => true
                ]);
                return json_encode('Notificaciones leidas');
    }

}
