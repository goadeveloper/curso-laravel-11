<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        $tasks = $user->tasks;
        return view('dashboard', compact('tasks'));
    }
}
