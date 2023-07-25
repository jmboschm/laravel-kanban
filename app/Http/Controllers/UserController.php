<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{

    public function __invoke(Request $request)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $token = PersonalAccessToken::findToken($sactumToken);
        $user = $token->tokenable;
        return $user::all();
    }

}
