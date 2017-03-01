<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Service;

class ServiceController extends Controller
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
        $services = Service::latest()->paginate(5);
        return view('servicios.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->all());
        session()->flash('flash_message', 'Se ha agregado el servicio: '.$service->title);
        return redirect('servicios');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('servicios.edit', compact('service'));
    }

    /**
     * Get the json of the specified resource.
     *
     * @param  String  $title
     * @return \Illuminate\Http\Response
     */
    public function getServiceByTitle($title)
    {
        $service = Service::where('title', $title)->first();
        return $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ServiceRequest  $request
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado el servicio: '.$service->name);
        return redirect('servicios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        session()->flash('flash_message', 'Se ha eliminado el servicio');
        return redirect('servicios');
    }
}
