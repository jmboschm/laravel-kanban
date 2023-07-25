<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function __invoke(Request $request)
    {
        
    }
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
        /* If user is admin asign to specific ID else assign to authUser */
       /* $assignee =
          ($request->user_id && auth()->user()->isAdmin ?
          $request->user_id :
          $assignee = auth()->user()->id);
*/
        Appointment::create([
          'start_time' => $request->start,
          'finish_time' => $request->end,
          'title' => $request->title,
          'color' => $request->typeVacation,
          'user_id' => $request->user_id,
          'booked_by' => (Auth::user()->isAdmin ? $request->user_id : $request->user_id)
        ]);

       
        /*
            Appointment::create([
            'title' => $request->title,
            'start_time' => $request->start,
            'finish_time' => $request->end,
            'color' => $request->typeVacation,
            'user_id' => $request->user_id
        ]);*/

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
        $user = auth()->user();
        if ($appointment->user_id === $user->id || $user->isAdmin) {
          $appointment->update($request->all());
        } else {
          abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $user = auth()->user();
        if ($appointment->user_id === $user->id || $user->isAdmin) {
            $appointment->delete();
        } else {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        if (auth()->user()->isAdmin) {
          return Appointment::whereBetween('start', [$request->start, $request->end])
                  ->with('user:id,name,lastname')
                  ->get();
        } else {
          return Appointment::whereBetween('start', [$request->start, $request->end])
                  ->where('user_id', auth()->user()->id)
                  ->get();
        }
    }
}
