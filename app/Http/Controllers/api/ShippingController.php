<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function setShippingEvidence(Request $request)
    {
        if ($request->input('photos')) {
            $shipping = Shipping::updateOrCreate(
                ['order_id' => $request->input('order_id')],
                ['user_id' => $request->input('user_id')]
            );

            for ($i = 0; $i < count($request->input('photos')[0]); $i++) {
                $file = $request->input('photos')[0][$i];
                $data = $file['base64Data'];

                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        throw new \Exception('invalid image type');
                    }
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                } else {
                    throw new \Exception('did not match data URI with image data');
                }
                $url = './images/admin/shippings/' . date("YmdHis") . $i . '.' . $type;
                file_put_contents($url, $data);
                
                    $shipping->images()->create([
                                'url' => $url
                            ]);
            }
            return json_encode("Fotos subidas correctamente");
        } 
        // else {

        //     if ($request->input('video')) {
        //         $file = $request->input('video');
        //         $extension = $file->getClientOriginalExtension();
        //         $request->validate([
        //             'file' => 'max:10024'
        //         ]);

        //         $nombrearchivo  = rand(0, 9) . $request->input('user_id') . "_" . date("YmdHis") . "." . $extension;
        //         $file->move(public_path("videos/admin/envios/"), $nombrearchivo);
        //     }
        // }
        // $shipping = Shipping::create([
        //     'user_id' => $request->input('user_id'),
        //     'order_id' => $request->input('order_id')
        // ]);
        // if ($request->input('photos')) {
        //     $shipping->images()->create([
        //         'url' => $url
        //     ]);
        // }
        // if($request->input('video')){
        //     $shipping->videos()->create([
        //         'url' => "videos/admin/envios/" . $nombrearchivo
        //     ]);
        // }
    }

    public function setTrackingNumber(Request $request){
        Shipping::where('id', $request->input('shipping_id'))
                ->update([
                    'tracking_number' => $request->input('tracking_number')
                ]);
        
        return "Guia actualizada";
    }

    public function getShippingEvidence(Request $request){
        $evidence = Shipping::with('images')
                    ->where('order_id', $request->input('order_id'))
                    ->get();

        return $evidence;
    }
}
