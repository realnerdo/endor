<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EstimateRequest;
use App\Http\Requests\EstimateEmailRequest;
use Carbon\Carbon;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Estimate;
use App\EstimateService;
use App\Client;
use App\Service;
use App\User;
use App\Setting;
use Mail;
use App\Mail\EstimateGenerated;
use Auth;
use Config;

class EstimateController extends Controller
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
        $estimates = Estimate::latest()->paginate(5);
        $settings = Setting::first();
        return view('cotizaciones.index', compact('estimates', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::pluck('name', 'id');
        $clients = [''=>''] + $clients->toArray();
        $services = Service::pluck('title', 'title');
        $services = [''=>''] + $services->toArray();
        $users = User::pluck('name', 'id');
        return view('cotizaciones.create', compact('clients', 'services', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EstimateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstimateRequest $request)
    {
        $latest = Estimate::latest()->first();
        $folio = (is_null($latest)) ? sprintf('%05d', 1) : sprintf('%05d', substr($latest->folio, 0, -1) + 1);

        $initials = '';
        $names = preg_split("/\s+/", Auth::user()->name);
        foreach ($names as $n) {
          $initials .= $n[0];
        }
        $initials = strtoupper($initials);

        $folio = $folio . $initials;
        $request->merge(['folio' => $folio]);

        if(!is_numeric($request->input('client_id'))){
            $request->merge(['name' => $request->input('client_id')]);
            $client = Client::create($request->all());
            $request->merge(['client_id' => $client->id]);
        }

        $estimate = Auth::user()->estimates()->create($request->all());

        foreach ($request->input('services') as $key => $service) {
            $estimate->estimate_services()->create([
                'title' => $service['title'],
                'content' => $service['content'],
                'notes' => $service['notes'],
                'price' => $service['price'],
                'duration' => $service['duration'],
                'offset' => $service['offset']
            ]);
        }

        session()->flash('flash_message', 'Se ha generado la cotización: '.$estimate->folio);

        return redirect('cotizaciones');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estimate $estimate)
    {
        $clients = Client::pluck('name', 'id');
        $clients = [''=>''] + $clients->toArray();
        $services = Service::pluck('title', 'title');
        $services = [''=>''] + $services->toArray();
        $users = User::pluck('name', 'id');
        return view('cotizaciones.edit', compact('estimate', 'clients', 'services', 'users'));
    }

    /**
     * Show the pdf of the specified resource.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function download(Estimate $estimate)
    {
        $setting = Setting::latest()->first();
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 25);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 20);
        $filename = $setting->company.' - Cotización para '.$estimate->client->name.'['.Carbon::now().'].pdf';
        return $pdf->download($filename);
    }

    /**
     * Show the pdf of the specified resource.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function pdf(Estimate $estimate)
    {
        $setting = Setting::latest()->first();
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 25);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 20);
        $filename = $setting->company.' - Cotización para '.$estimate->client->name.'['.Carbon::now().'].pdf';
        return $pdf->stream($filename);
        // return view('cotizaciones.pdf', compact('estimate'));
    }

    private function pdfHeader($estimate)
    {
        return view('cotizaciones.header', compact('estimate'));
    }

    private function pdfFooter()
    {
        return view('cotizaciones.footer');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Estimate  $request
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function update(EstimateRequest $request, Estimate $estimate)
    {
        foreach ($estimate->estimate_services as $service) {
            EstimateService::find($service->id)->delete();
        }

        if(!is_numeric($request->input('client_id'))){
            $request->merge(['name' => $request->input('client_id')]);
            $client = Client::create($request->all());
            $request->merge(['client_id' => $client->id]);
        }

        $estimate->update($request->all());

        foreach ($request->input('services') as $key => $service) {
            $estimate->estimate_services()->create([
                'title' => $service['title'],
                'content' => $service['content'],
                'notes' => $service['notes'],
                'price' => $service['price'],
                'duration' => $service['duration'],
                'offset' => $service['offset']
            ]);
        }
        session()->flash('flash_message', 'Se ha actualizado la cotización: '.$estimate->folio);
        return redirect('cotizaciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        session()->flash('flash_message', 'Se ha eliminado la cotización');
        return redirect('cotizaciones');
    }
}
