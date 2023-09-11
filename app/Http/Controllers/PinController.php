<?php

namespace App\Http\Controllers;

use App\Models\Pin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinController extends Controller
{
    public function getPins() {
        // return response()->json(Pin::get(['pin', 'state', 'device', 'updated_at']));
        $pins = [];
        foreach (Pin::get(['pin', 'state']) as $pin) {
            $pins[$pin->pin] = $pin->state;
        }
        return response()->json($pins);
    }

    public function updatePin(Request $request, string $pin) {
        $validator = Validator::make($request->all(), [
            'state' => 'required|string|in:0,1',
            'method' => 'required|string|in:web,rfid'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Bad Request'
            ], 400);
        }

        $pins_available = [];
        foreach (Pin::get('pin') as $name) {
            $pins_available[] = $name->pin;
        }
        if (!in_array($pin, $pins_available)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Pin unavailable'
            ]);
        }

        $pin_updated = Pin::find($pin);
        $isUpdated = $pin_updated->update([
            'state' => $request->input('state')
        ]);

        // 
        return response()->json($isUpdated);
    }
}
