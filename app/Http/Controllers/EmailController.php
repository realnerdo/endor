<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use Carbon\Carbon;

class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::latest()->paginate(15);
        return view('emails.index', compact('emails'));
    }
}
