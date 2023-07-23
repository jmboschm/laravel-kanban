<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
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

        dd($request->all());
        $assignee = ($request->user_id && auth()->user()->isAdmin ?
        $request->user_id : $assignee = auth()->user()->id);
        //dd($request->all());
            Appointment::create([
            'title' => $request->title,
            'start_time' => $request->start,
            'finish_time' => $request->end,
            'color' => $request->typeVacation,
            'booked_by' => $assignee,
            'user_id' => $assignee
        ]);

       // dd(Appointment::class);
    
        return redirect()->back()->with('message','Reservado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
