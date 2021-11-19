<?php

namespace Laravel\Fortify\Http\Responses;

use App\Models\Country;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $country = Country::where('id', auth()->user()->country_id)->first();
        $home = 'home/' . $country['tld'];
        return redirect()->intended($home);
        // return $request->wantsJson()
        //     ? response()->json(['two_factor' => false])
        //     : redirect()->intended(config('fortify.home'));
    }
}
