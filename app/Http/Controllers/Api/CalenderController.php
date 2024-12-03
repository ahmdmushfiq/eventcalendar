<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function eventCreate(Request $request){
        $calendar = new Calender();
        $calendar->user_id = Auth::user()->id;
        $calendar->event_name = $request->event_name;
        $calendar->event_date = $request->event_date;
        $calendar->description = $request->description;
        $calendar->save();

        return response()->json([
            'message' => 'Event created successfully',
        ], 200);
    }

    public function eventUpdate(Request $request){
        $calendar = Calender::find($request->id);
        $calendar->event_name = $request->event_name;
        $calendar->event_date = $request->event_date;
        $calendar->description = $request->description;
        $calendar->update();

        return response()->json([
            'message' => 'Event updated successfully',
        ], 200);
    }

    public function eventDelete(Request $request){
        $calendar = Calender::find($request->id);
        $calendar->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
        ], 200);
    }
}
