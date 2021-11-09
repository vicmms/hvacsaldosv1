<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppInfoController extends Controller


{
    public function getReleaseCurrent(){
        $releaseCurrent [] = array( 
                             "enabled" => true,
                             "current"=> "5",
                             "title" => "Se encuentra en mantenimiento", 
                             "msg"=> "Existe una actualización que debe ser instalada inmediatamente",
                             "btn"=> "Descargar");
      
        // $majorMsg->btn = "Descargar";

        $json = json_encode($releaseCurrent);


        return $json;
    }
}
