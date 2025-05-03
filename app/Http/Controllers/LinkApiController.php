<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkApiController extends Controller
{
    public function index(Request $request, $apikey)
    {
        $link = \App\Models\Link::where('apikey', $apikey)->first();
        if (!$link) {
            return response()->json(['message' => 'Link not found'], 404);
        }

        return response()->json($link);
    }
}
