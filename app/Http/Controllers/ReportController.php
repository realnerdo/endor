<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estimate;
use App\Client;
use App\User;
use App\Service;
use Carbon\Carbon;
use Excel;

class ReportController extends Controller
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

        if(!$search['all']->isEmpty()){
            $selled_total = 0;
            $not_selled_total = 0;
            $pending_total = 0;
            foreach ($search['all'] as $estimate) {
                if($estimate->status == 'Vendida con descuento')
                    $selled_total = $selled_total + $estimate->discount;
                if($estimate->status == 'Vendida')
                    $selled_total = $selled_total + $estimate->total;
                if($estimate->status == 'No vendida')
                    $not_selled_total = $not_selled_total + $estimate->total;
                if($estimate->status == 'En espera')
                    $pending_total = $pending_total + $estimate->total;
            }
        }

        $clients = Client::pluck('name', 'id');
        $clients = [0 => 'Todos'] + $clients->toArray();
        $users = User::pluck('name', 'id');
        $users = [0 => 'Todos'] + $users->toArray();
        $services = Service::pluck('title', 'title');
        $services = [0 => 'Todos'] + $services->toArray();
        $statuses = [0 => 'Todos', 'En espera' => 'En espera', 'Vendida' => 'Vendida', 'Vendida con descuento' => 'Vendida con descuento', 'No vendida' => 'No vendida'];
        $estimates = $search['paginated'];
        return view('reportes.index', compact(
            'request',
            'values',
            'estimates',
            'clients',
            'users',
            'services',
            'statuses',
            'selled_total',
            'not_selled_total',
            'pending_total'
        ));
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
        if($request->has('client_id'))
            $showing .= ' del cliente "' . $first->client->name . '"';
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
            $result['paginated'] = Estimate::latest()->paginate(15);
            $result['all'] = Estimate::latest()->get();
    	}else{
    	    $estimates = Estimate::latest();
    	    if($request->has('from') && $request->input('from') != '')
                $estimates = $estimates->where('created_at', '>=', $request->input('from'));
    	    if($request->has('to')){
                $to = ($request->input('to') != '') ? $request->input('to') : Carbon::today();
                $estimates = $estimates->where('created_at', '<=', $to);
            }
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
    	    $result['paginated'] = $estimates->paginate(15);
            $result['all'] = Estimate::latest()->get();
    	}

    	return $result;
    }
}
