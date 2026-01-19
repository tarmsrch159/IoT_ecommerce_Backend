<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getProvinces()
    {
        return response()->json(
            Province::orderBy('name_th')->get(['id', 'name_th'])
        );
    }
}
