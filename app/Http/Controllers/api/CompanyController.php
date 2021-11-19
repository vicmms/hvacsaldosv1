<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CompanyController extends Controller
{
    public function getCompany(Request $request)
    {
        return DB::table('companies')
            ->where('user_id', $request->input('user_id'))
            ->get();
    }

    public function setCompany(Request $request)
    {
        DB::table('companies')
            ->updateOrInsert(
                ['user_id' => $request->input('user_id')],
                [
                    'name' => $request->input('name'),
                    'tax_data' => $request->input('tax_data'),
                ]
            );

        return json_encode("Empresa actualizada");
    }
}
