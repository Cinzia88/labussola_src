<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scadenziario;

class TasksCalendarController extends Controller
{
    public function index()
    {
        $events = Scadenziario::whereNull('eseguito')->orWhere('eseguito', '=', 0)->get();
        $events->load('preventivo');
        return view('admin.tasksCalendars.index', compact('events'));
    }
}
