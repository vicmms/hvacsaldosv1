<?php

namespace Laravel\Fortify\Http\Responses;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // return $request->wantsJson()
        //             ? new JsonResponse('', 201)
        //             : redirect()->intended(config('fortify.home'));
        $country = Country::where('id', auth()->user()->country_id)->first();
        $home = 'home/' . $country['tld'];
        return redirect()->intended($home);
    }
}
