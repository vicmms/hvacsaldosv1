<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Video;
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
            
        }


        if ($request->input('video')) {
            $request->validate([
                'file' => 'max:10024'
            ]);


                $data = $request->input('video');
                $data = preg_replace('/[^a-zA-Z0-9`_.,;@#%~\’\'\"+*\?\^\[\]\$\(\)\{\}\=!\<\>\|\-:\s\/\\sàâçéèêëîïôûùüÿñæœ]/ui', '', $data);
                // if (preg_match('/^data:video\/(\w+);base64,/', $data, $type) || preg_match('/^data:video\/(\w+);charset=utf-8;base64,/', $data, $type)) {
                    $data = trim(explode(',', $data)[1]);
                    $type = 'mp4';//strtolower($type[1]); // mp4
                    // return json_encode($data);
                    // if (!in_array($type, ['mp4'])) {
                    //     throw new \Exception('invalid video type');
                    // }
                    // $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                // } else {
                //     throw new \Exception('did not match data URI with video data');
                // }



            $url = './videos/admin/envios/' . date("YmdHis") . $i . '.mp4';
            file_put_contents($url,$data);

            $shipping = Shipping::updateOrCreate(
                ['order_id' => $request->input('order_id')],
                ['user_id' => $request->input('user_id')]
            );

            $shipping->videos()->create([
                'url' => "videos/admin/envios/" . $url
            ]);
        }

        return json_encode("Evidencias subidas correctamente");

    }

    public function setTrackingNumber(Request $request)
    {
        $shipping = Shipping::where('id', $request->input('shipping_id'));
        $shipping->update([
            'tracking_number' => $request->input('tracking_number')
        ]);

        Order::where('id', $shipping->first()->order_id)
            ->update([
                'status' => 6
            ]);


        return json_encode("Guia actualizada");
    }

    public function getShippingEvidence(Request $request)
    {
        $evidence = Shipping::with('images')
            ->with('videos')
            ->where('order_id', $request->input('order_id'))
            ->get();

        return $evidence;
    }

    public function deleteVideo(Request $request)
    {
        $video = Video::find($request->input('id'));
        unlink($video->url);
        $video->delete();
        return json_encode("Video eliminado");
    }
}
