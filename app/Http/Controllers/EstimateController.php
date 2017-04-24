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
        $estimates = (Auth::user()->role == 'admin') ? Estimate::latest()->paginate(15) : Auth::user()->estimates()->latest()->paginate(15);
        $statuses = ['En espera' => 'En espera', 'Vendida' => 'Vendida', 'Vendida con descuento' => 'Vendida con descuento', 'No vendida' => 'No vendida'];
        $settings = Setting::first();
        return view('cotizaciones.index', compact('estimates', 'statuses', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::latest()->first();
        $clients = Client::pluck('name', 'id');
        $clients = [''=>''] + $clients->toArray();
        $services = Service::pluck('title', 'title');
        $services = [''=>''] + $services->toArray();
        $statuses = ['En espera' => 'En espera', 'Vendida' => 'Vendida', 'Vendida con descuento' => 'Vendida con descuento', 'No vendida' => 'No vendida'];
        $origins = ['Google' => 'Google', 'LinkedIn' => 'LinkedIn', 'Llamada' => 'Llamada', 'Referido' => 'Referido'];
        $payment_types = ['Normal' => 'Normal', 'Mensual' => 'Mensual'];
        $users = User::pluck('name', 'id');
        return view('cotizaciones.create', compact('clients', 'services', 'statuses', 'origins', 'payment_types', 'users', 'setting'));
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
        $folio = (is_null($latest)) ? sprintf('%05d', 1) : sprintf('%05d', substr($latest->folio, 0, 5) + 1);

        $initials = '';
        $name = trim(Auth::user()->name);
        $names = preg_split("/\s+/", $name);
        foreach ($names as $n) {
            $name = iconv('UTF-8', 'ASCII//TRANSLIT', $n);
            $initials .= $name[0];
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
            $estimate_service = $estimate->estimate_services()->create([
                'title' => $service['title'],
                'notes' => $service['notes'],
                'price' => $service['price'],
                'duration' => $service['duration'],
                'offset' => $service['offset']
            ]);

            foreach ($service['sections'] as $section) {
                $estimate_service->estimate_sections()->create([
                    'title' => $section['title'],
                    'content' => $section['content']
                ]);
            }
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
        $statuses = ['En espera' => 'En espera', 'Vendida' => 'Vendida', 'Vendida con descuento' => 'Vendida con descuento', 'No vendida' => 'No vendida'];
        $origins = ['Google' => 'Google', 'LinkedIn' => 'LinkedIn', 'Llamada' => 'Llamada', 'Referido' => 'Referido'];
        $payment_types = ['Normal' => 'Normal', 'Mensual' => 'Mensual'];
        $users = User::pluck('name', 'id');
        return view('cotizaciones.edit', compact('estimate', 'clients', 'statuses', 'origins', 'payment_types', 'services', 'users'));
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
        $filename = $estimate->client->name.' - '. $estimate->service . '.pdf';
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
        $filename = $estimate->client->name.' - '. $estimate->service . '.pdf';
        return $pdf->stream($filename);
        // return view('cotizaciones.pdf', compact('estimate'));
    }

    private function pdfHeader($estimate)
    {
        $setting = Setting::latest()->first();
        return view('cotizaciones.header', compact('estimate', 'setting'));
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

        if(!$request->has('discount'))
            $request->merge(['discount' => null]);

        $estimate->update($request->all());

        foreach ($request->input('services') as $key => $service) {
            $estimate_service = $estimate->estimate_services()->create([
                'title' => $service['title'],
                'notes' => $service['notes'],
                'price' => $service['price'],
                'duration' => $service['duration'],
                'offset' => $service['offset']
            ]);

            foreach ($service['sections'] as $section) {
                $estimate_service->estimate_sections()->create([
                    'title' => $section['title'],
                    'content' => $section['content']
                ]);
            }
        }
        session()->flash('flash_message', 'Se ha actualizado la cotización: '.$estimate->folio);
        return redirect('cotizaciones');
    }

    public function changeStatus(Request $request, Estimate $estimate)
    {
        $estimate->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado el estatus de la cotización: "'.$estimate->folio.'" a "'.$estimate->status.'"');
        return 'success';
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
