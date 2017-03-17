<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estimate;
use App\Client;
use App\User;
use App\Service;
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
    	$estimates = $this->search($request);

        $clients = Client::pluck('name', 'id');
        $clients = [0 => 'Todos'] + $clients->toArray();
        $users = User::pluck('name', 'id');
        $users = [0 => 'Todos'] + $users->toArray();
        $services = Service::pluck('title', 'title');
        $services = [0 => 'Todos'] + $services->toArray();
        $statuses = [0 => 'Todos', 'En espera' => 'En espera', 'Vendida' => 'Vendida', 'No vendida' => 'No vendida'];
        return view('reportes.index', compact('request', 'values', 'estimates', 'clients', 'users', 'services', 'statuses'));
    }

    public function exportExcel(Request $request)
    {
    	$estimates = $this->search($request);
    	$showing = 'Reporte de cotizaciones ';
    	$first = $estimates->first();
    	if($request->has('from') && $request->has('to'))
    		$showing .= ' desde "' . $request->input('from') . '" hasta "' . $request->input('to') . '"';
    	if($request->has('client_id'))
    		$showing .= ' del cliente "' . $first->client->name . '"';
    	if($request->has('user_id'))
    		$showing .= ' del empleado "' . $first->user->name . '"';
    	if($request->has('service_title')){
    		$service = \App\Service::find($request->input('service_title'));
    		if($service)
    			$showing .= ' del servicio "' . $service->title . '"';
    	}
        if($request->has('status'))
            $showing .= ' con el estatus "' . $request->input('status') . '"';
    	if(!$estimates->isEmpty()){
    		$total = ($estimates->count() > 1) ? 'Mostrando ' . $estimates->count() . ' cotizaciones' : 'Mostrando ' . $estimates->count() . ' cotización';
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
    	    $estimates = Estimate::latest()->paginate(5);
    	}else{
    	    $estimates = Estimate::latest();
    	    if($request->has('from') && $request->input('from') != '')
    	        $estimates = $estimates->where('created_at', '>=', $request->input('from'));
    	    if($request->has('to') && $request->input('to') != '')
    	        $estimates = $estimates->where('created_at', '<=', $request->input('to'));
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
    	    $estimates = $estimates->paginate(5);
    	}

    	return $estimates;
    }
}
