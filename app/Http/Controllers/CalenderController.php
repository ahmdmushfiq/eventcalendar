<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $calendar = new Calender();
        $calendar->user_id = Auth::user()->id;
        $calendar->event_name = $request->event_name;
        $calendar->event_date = $request->event_date;
        $calendar->description = $request->description;
        $calendar->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $calendar = Calender::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $calendar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $calendar = Calender::find($id);
        $calendar->event_name = $request->event_name;
        $calendar->event_date = $request->event_date;
        $calendar->description = $request->description;
        $calendar->update();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calendar = Calender::find($id);
        $calendar->delete();

        return response()->json([
            'status' => 'success',
        ]);    
    }

    public function getCalendarEvents(Request $request) {
        $start = date("Y-m-d", strtotime($request->start));
        $end = date("Y-m-d", strtotime($request->end));
        $noOfDays = Carbon::parse($start)->diffInDays(Carbon::parse($end));
        $user_id = Auth::user()->id;
        $events = collect();
        for ($i = 0; $i <= $noOfDays; $i++) {
            $date = Carbon::parse($start)->addDays($i)->format('Y-m-d');
            $calendars = Calender::where('user_id', $user_id)->where('event_date', $date)->get();
            foreach ($calendars as $calendar) {
                $events->push([
                    'title' => $calendar->event_name,
                    'start' => $calendar->event_date,
                    'description' => $calendar->description,
                    'id' => $calendar->id,
                    'backgroundColor' => '#1abc9c',
                ]);
            }
        }
        return response()->json($events);
    }
}
