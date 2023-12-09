<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerProfileController extends Controller
{
    public function getProfile()
    {
        $record['worker'] = session()->get('user');
        return view('Worker/workerProfile',$record);
    }
}
