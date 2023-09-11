<?php

namespace App\Http\Controllers\Remote;

use App\Http\Controllers\Controller;
use App\Models\DHT;
use App\Models\Pin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $pins = Pin::get(['pin', 'device', 'state']);
        $dht = DHT::find('now');
        return view('remote.index', compact('pins', 'dht'));
    }

    public function monitor() {
        $pins = Pin::get(['pin', 'device', 'state']);
        $dht = DHT::find('now');
        return response()->json(compact('pins', 'dht'));
    }
}
