<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppInfoController extends Controller


{
    public function getReleaseCurrent(){
        $releaseCurrent [] = array( 
                             "enabled" => true,
                             "current"=> "7",
                             "title" => "Actualización requerida", 
                             "msg"=> "Existe una actualización que debe instalarse",
                             "btn"=> "Descargar");
      
        // $majorMsg->btn = "Descargar";

        $json = json_encode($releaseCurrent);


        return $json;
    }
}
