<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Inertia\Inertia;
use DB;


class AppointmentController extends Controller
{

    public function __invoke(Request $request)
    {
        /*return Inertia::render('Agenda/Books',[
            'users' => User::all()    
        ]);*/
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
       
        $events = [];

        foreach($appointments as $appointment) {
            $event = [];
            $event['id'] = $appointment->id;
            $event['title'] = $appointment->title;
            $event['start'] = $appointment->start_time;
            $event['end'] = $appointment->finish_time;
            $event['color'] = $appointment->color;

            $events[] = $event;
        }

        return response()->json($events);
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
       
        $this->validate($request, [
            'title' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
            'color' => 'required',
            'user_id' => 'required',

        ]);*/   
        //dd($request->all());
     //   $validated = $request->validated();
        $start_time = Carbon::parse($request->date_at);
        $finish_time = Carbon::parse($request->end_at)->addDay();
        
        
        $title = User::find($request->user_id);
        
      //  dd($title->name);
        Appointment::create([
          'start_time' => $start_time,//$request->date_at,
          'finish_time' => $finish_time,//$request->end_at,
          'title' => $title->name,//$request->title,
          'color' => $request->color,
          'user_id' => $request->user_id,
        ]);

    
        return redirect()->back()->with(['success'=>'Reservado con éxito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return Inertia::render('Appointment/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return Inertia::render('Appointment/Edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //$user = auth()->user();
        //if ($appointment->user_id === $user->id || $user->isAdmin) {
            //dd($request->all());
            $start_time = Carbon::parse($request->start_time);
            $finish_time = Carbon::parse($request->finish_time)->addDay();
            $appointment->update([
                'id' => $request->id,
                'user_id' => $request->user_id,
                'color' => $request->color,
                'start_time' => $start_time,
                'finish_time' => $finish_time]);
          return redirect()->back()->with('success', 'El proceso ha sido actualizado con éxito');
        //} else {
        //  abort(403);
        //}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
       // dd($appointment);
       /* $appointment = Appointment::where('start_time','=',$request->end_at)
        ->where('finish_time','=',$request->end_at)
        ->where('user_id','=',$request->user_id)
        ->where('title','=',$request->title)->find()->get();*/
      //  $user = auth()->user();
      //  if ($appointment->user_id === $user->id || $user->isAdmin) {
            $appointment->delete();
            return redirect()->back()->with('success', 'El proceso ha sido borrado con éxito');
      //  }
      //   else {
      //      abort(403);
      //  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request, $type)
    {
        
       //dd($request->all());
       //$appointment = $request->all()->toArray();
      // $object = (object) $request;
       //dd($request['parseado']['id'][0]);
      if($type == 1){
        return Appointment::findOrFail($request['parseado']['id'][0]);
      } else {
        //dd($request->all());
        return Appointment::where('user_id',$request['parseado']['user_id'][0])
        ->where('start_time',$request['parseado']['start'][0])
        ->where('finish_time',$request['parseado']['end'][0])
        ->get();
      }
    }

    public function baixes()
    {

      $appointments = Appointment::with('user:id,name')->where('color','=','black')->get();

      $users = User::all();
      $total = 0;
  
        for ($m=1; $m<=12; $m++) {
          $month[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
          $baixes[] = 0;
        }
        
 
          $total = 0;

   
          foreach($appointments as $appointment){
            
            $diff_in_days = 0;
            $lastDayofMonth = Carbon::parse($appointment->start_time)->endOfMonth()->toDateTimeString();
            $firstDayOfMonth = Carbon::parse($appointment->finish_time)->firstOfMonth()->toDateTimeString();
           
            /**
             * Si la baixa comença i acaba al mateix mes
             */
            if(Carbon::parse($appointment->start_time)->format('m') == (Carbon::parse($appointment->finish_time)->format('m'))) {
              $diff_in_days = Carbon::parse($appointment->start_time)->diffInDays(Carbon::parse($appointment->finish_time));
                if($diff_in_days == 0){
                  $diff_in_days++;
                }
                $total += $diff_in_days;
                $monthNumber = Carbon::parse($appointment->start_time)->month;
                $baixes[$monthNumber] = $total;
            }

            
            
            /**
             * Si la baixa no coincideix en el mateix mes el inici i el final
             */
            else if((Carbon::parse($appointment->start_time)->format('m')) != (Carbon::parse($appointment->finish_time)->format('m'))){
              /**
               * Si la baixa ha començat un mes però acaba en un altre mes, comptar només els dies de baixa d'aquest més
               * Si la baixa comença un mes però acaba en un altre mes, comptar només els dies de baixa de l'ultim mes
               */
                
                $lastDayofMonth = Carbon::parse($appointment->start_time)->endOfMonth()->toDateTimeString();
                $diff_in_days = Carbon::parse($appointment->start_time)->diffInDays(Carbon::parse($lastDayofMonth));
                if($diff_in_days == 0){
                  $diff_in_days++;
                }
                $total += $diff_in_days;
                $monthNumber = Carbon::parse($appointment->start_time)->month;
                $baixes[$monthNumber] = $total;

                $diff_in_days = 0;
                $total = 0;
                
                
                $firstDayOfMonth = Carbon::parse($appointment->finish_time)->firstOfMonth()->toDateTimeString();
                //dd(Carbon::parse($appointment->finish_time)->toDateTimeString());
                $diff_in_days = Carbon::parse($firstDayOfMonth)->diffInDays(Carbon::parse($appointment->finish_time));
                if($diff_in_days == 0){
                  $diff_in_days++;
                }
               
                $total += $diff_in_days;
                $monthNumber = Carbon::parse($appointment->start_time)->month;
                $baixes[$monthNumber+1] = $total;
                         
          }
        }
          
      
        
      $data['months'] = $month;
    
      $data['baixes'] = $baixes;


      //dd($data);
      return Inertia::render('Chart',['data' => $data]);
        
    }
}
