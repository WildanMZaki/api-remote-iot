<?php

namespace App\Http\Controllers;

use App\Models\DHT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DHTController extends Controller
{
    public function dht() {
        return response()->json(DHT::find('now'));
    }

    public function updateDHT(Request $request) {
        $validator = Validator::make($request->all(), [
            'temp' => 'required',
            'humi' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Bad Request'
            ], 400);
        }

        $dht = DHT::find('now');
        $dht->update([
            'temperature' => $request->input('temp'),
            'humidity' => $request->input('humi'),
        ]);
        return response('Success updating data');
    }
}
