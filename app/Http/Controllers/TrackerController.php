<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use Carbon\Carbon;

class TrackerController extends Controller
{
    public function opened(Email $email)
    {
        if(is_null($email->opened_at))
            $email->update(['opened_at' => Carbon::now()]);
        $counter = (is_null($email->opened_times)) ? 0 : $email->opened_times;
        $email->update(['opened_times' => $counter + 1]);
    }
}
