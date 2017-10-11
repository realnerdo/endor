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
use Mail;
use App\Mail\EstimateGenerated;

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
    public function index(Request $request)
    {
    	$values = '';
    	foreach($request->all() as $key => $value){
    		$value = (!$value) ? $request->merge([$key => '']) : $value;
    	    if($key != 'page') $values .= $value;
    	}
    	$search = $this->search($request);

        /* if(!$search['all']->isEmpty()){ */
        /*     $selled_total = 0; */
        /*     $not_selled_total = 0; */
        /*     $pending_total = 0; */
        /*     foreach ($search['all'] as $estimate) { */
        /*         if($estimate->status == 'Vendida con descuento') */
        /*             $selled_total = $selled_total + $estimate->discount; */
        /*         if($estimate->status == 'Vendida') */
        /*             $selled_total = $selled_total + $estimate->total; */
        /*         if($estimate->status == 'No vendida') */
        /*             $not_selled_total = $not_selled_total + $estimate->total; */
        /*         if($estimate->status == 'En espera') */
        /*             $pending_total = $pending_total + $estimate->total; */
        /*     } */
        /* } */

        $clients = Client::pluck('name', 'id');
        $clients = [0 => 'Todos'] + $clients->toArray();
	$companies = Client::pluck('company', 'company');
        $companies = [0 => 'Todas'] + $companies->toArray();
	$companies = array_filter($companies);
        $users = User::pluck('name', 'id');
        $users = [0 => 'Todos'] + $users->toArray();
        $services = Service::pluck('title', 'title');
        $services = [0 => 'Todos'] + $services->toArray();
        $statuses = [0 => 'Todos', 'En espera' => 'En espera', 'Vendida' => 'Vendida', 'Vendida con descuento' => 'Vendida con descuento', 'No vendida' => 'No vendida'];
        $estimates = $search['paginated'];
        $settings = Setting::first();
        return view('cotizaciones.index', compact(
            'request',
            'values',
            'estimates',
            'clients',
	    'companies',
            'users',
            'services',
            'statuses',
            'selled_total',
            'not_selled_total',
	    'pending_total',
	    'settings'
        ));
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
            $price = str_replace(',', '', $service['price']);
            $estimate_service = $estimate->estimate_services()->create([
                'title' => $service['title'],
                'notes' => $service['notes'],
                'price' => $price,
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
     * Send estimate via email.
     *
     * @param  \App\Http\Requests\EstimateEmailRequest  $request
     * @param  Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function email(EstimateEmailRequest $request, Estimate $estimate)
    {
        // Email
        $email = $estimate->emails()->create([
            'to' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message')
        ]);

        $setting = Setting::latest()->first();
        $header = $this->pdfHeader($estimate);
        $footer = $this->pdfFooter();
        $pdf = \PDF::loadView('cotizaciones.pdf', ['estimate' => $estimate]);
        $pdf->setOption('header-html', $header)->setOption('margin-top', 25);
        $pdf->setOption('footer-html', $footer)->setOption('margin-bottom', 20);
        $filename = $estimate->client->name.' - '. $estimate->service;
        $slug = str_slug($filename);
        $path = 'storage/cotizaciones/'.$slug.'.pdf';
        $pdf->save($path, true);
        $request->merge(['pdf' => $path]);
        Config::set('mail.username', Auth::user()->email);
        Config::set('mail.password', Auth::user()->email_password);
        Config::set('mail.from', ['address' => Auth::user()->email, 'name' => Auth::user()->name]);
        Mail::to($request->input('email'))->send(new EstimateGenerated($estimate, $request, $email));
        unlink($path);

        session()->flash('flash_message', 'Se ha enviado la cotización '.$estimate->folio.' al correo: '.$request->input('email'));
        return redirect('cotizaciones');
        // return view('emails.estimate', compact('estimate', 'request'));
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
            $price = str_replace(',', '', $service['price']);
            $estimate_service = $estimate->estimate_services()->create([
                'title' => $service['title'],
                'notes' => $service['notes'],
                'price' => $price,
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

    public function exportExcel(Request $request)
    {
        $search = $this->search($request);
    	$estimates = $search['all'];
    	$showing = 'Reporte de cotizaciones ';
    	$first = $estimates->first();
        if($request->has('from'))
            $showing .= ' desde "' . $request->input('from') . '"';
        else
            $showing .= ' desde la primera cotización';
        if($request->has('to'))
            $showing .= ' hasta "' . $request->input('to') . '"';
        else
            $showing .= ' hasta "' . Carbon::today()->toDateString() . '"';
	if($request->has('price_from'))
	    $showing .= ' desde "$' . number_format($request->input('price_from'), 2, '.', ',') . '"';
	if($request->has('price_to'))
	    $showing .= ' hasta "$' . number_format($request->input('price_to'), 2, '.', ',') . '"';
        if($request->has('client_id'))
            $showing .= ' del cliente "' . $first->client->name . '"';
	if($request->has('company'))
	    $showing .= ' de la empresa "' . $request->input('company') . '"';
        if($request->has('user_id'))
            $showing .= ' del ejecutivo "' . $first->user->name . '"';
        if($request->has('service_title')){
            $service = Service::where('title', $request->input('service_title'))->first();
            if($service)
                $showing .= ' del servicio "' . $service->title . '"';
        }
        if($request->has('status'))
            $showing .= ' con el estatus "' . $request->input('status') . '"';
    	if(!$estimates->isEmpty()){
    		$total = ($estimates->count() > 1) ? 'Resultados: ' . $estimates->count() . ' cotizaciones' : 'Resultados: ' . $estimates->count() . ' cotización';
    		$title = 'Reporte de cotizaciones';
    		$array = [];
    		foreach ($estimates as $estimate) {
    			$array[] = [
    				'Folio' => $estimate->folio,
    				'Fecha' => $estimate->created_at,
    				'Cliente' => $estimate->client->name,
    				'Empresa' => $estimate->client->company,
    				'Empleado' => $estimate->user->name,
    				'Servicio' => $estimate->service,
    				'Estatus' => $estimate->status,
    				'Total' => $estimate->total
    			];
    		}
    		$xls = Excel::create($title . ' ' . time(), function($excel) use ($title, $array, $showing, $total) {
    		    $excel->setTitle($title);
    		    $excel->sheet($title, function($sheet) use ($array, $showing, $total) {
    		        $sheet->fromArray($array);
    		        $sheet->prependRow(['']);
    		        $sheet->prependRow([$total]);
    		        $sheet->prependRow([$showing]);
    		        $sheet->mergeCells('A1:G1');
    		        $sheet->mergeCells('A2:G2');
    		        $sheet->mergeCells('A3:G3');
    		    });
    		});
    		return $xls->download('xls');
    	}
    	return abort(404);
    }

    private function search($request)
    {
    	$values = '';
    	foreach($request->all() as $key => $value){
    		$value = (!$value) ? $request->merge([$key => '']) : $value;
    	    if($key != 'page') $values .= $value;
    	}
    	if($values == ''){
            $result['all'] = Estimate::latest()->get();
            $result['paginated'] = Estimate::latest()->paginate(15);
    	}else{
	    $estimates = (Auth::user()->role == 'admin') ? Estimate::latest() : Auth::user()->estimates()->latest();
    	    if($request->has('from') && $request->input('from') != '')
                $estimates = $estimates->where('created_at', '>=', $request->input('from'));
    	    if($request->has('to')){
                $to = ($request->input('to') != '') ? $request->input('to') : Carbon::today();
                $estimates = $estimates->where('created_at', '<=', $to);
            }
    	    if($request->has('price_from') && $request->input('price_from') != '')
		$estimates = $estimates->where('total', '>=', $request->input('price_from'));
    	    if($request->has('price_to') && $request->input('price_to') != '')
		$estimates = $estimates->where('total', '<=', $request->input('price_to'));
    	    if($request->has('client_id') && $request->input('client_id') != '')
    	        $estimates = $estimates->where('client_id', $request->input('client_id'));
    	    if($request->has('user_id') && $request->input('user_id') != '')
    	        $estimates = $estimates->where('user_id', $request->input('user_id'));
            if($request->has('status') && $request->input('status') != '')
                $estimates = $estimates->where('status', $request->input('status'));
    	    if($request->has('service_title') && $request->input('service_title') != ''){
    	    	$estimates = $estimates->whereHas('estimate_services', function($query) use($request){
    	    		$query->where('title', $request->input('service_title'));
    	    	});
    	    }
	    if($request->has('company') && $request->input('company') != ''){
		$clients = Client::where('company', $request->input('company'))->get();
		if(!$clients->isEmpty()){
		    $estimates->where(function($query) use ($clients){
			$ci = 0;
			foreach($clients as $client){
			    if($ci){
			        $query->orWhere('client_id', $client->id);
			    } else {
			        $query->where('client_id', $client->id);
			    }
			    $ci++;

			}
		    });
		}
	    }
            $result['all'] = $estimates->get();
    	    $result['paginated'] = $estimates->paginate(15);
    	}

    	return $result;
    }
}
