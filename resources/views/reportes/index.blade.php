@extends('layout.base')

@section('title', 'Reportes')
@section('sectionTitle', 'Reportes')
@section('add')
	@unless($estimates->isEmpty())
	    <div class="buttons pr">
	        <a href="{{ url('reportes/exportExcel' . str_replace(url()->current(), '', url()->full())) }}" class="btn btn-green pr">Exportar a Excel</a>
	    </div>
	    <!-- /.buttons -->
	@endunless
@endsection

@section('content')
	<div class="row">
		{{ Form::open(['url' => url('reportes'), 'class' => 'form search', 'method' => 'GET']) }}
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('from', 'Desde', ['class' => 'label']) }}
					{{ Form::input('text', 'from', ($request->has('from')) ? $request->input('from') : null, ['class' => 'input datepicker whenever', 'required']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('to', 'Hasta', ['class' => 'label']) }}
					{{ Form::input('text', 'to', ($request->has('to')) ? $request->input('to') : null, ['class' => 'input datepicker whenever', 'required']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('client_id', 'Cliente', ['class' => 'label']) }}
					{{ Form::select('client_id', $clients, ($request->has('client_id')) ? $request->input('client_id') : null, ['class' => 'select2', 'data-placeholder' => 'Cliente']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('user_id', 'Empleado', ['class' => 'label']) }}
					{{ Form::select('user_id', $users, ($request->has('user_id')) ? $request->input('user_id') : null, ['class' => 'select2', 'data-placeholder' => 'Empleado']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('service_title', 'Servicio', ['class' => 'label']) }}
					{{ Form::select('service_title', $services, ($request->has('service_title')) ? $request->input('service_title') : null, ['class' => 'select2', 'data-placeholder' => 'Servicio']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('status', 'Estatus', ['class' => 'label']) }}
					{{ Form::select('status', $statuses, ($request->has('status')) ? $request->input('status') : null, ['class' => 'select2', 'data-placeholder' => 'Estatus']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-6">
				<div class="form-group">
					{{ Form::label('submit', 'Filtrar', ['class' => 'label']) }}
					{{ Form::submit('Aceptar', ['class' => 'btn btn-green']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-6 -->
		{{ Form::close() }}
	</div><!-- /.row -->
	<div class="row">
		@unless($estimates->isEmpty())
			@if($values == '')
				<div class="col-12">Mostrando todas las cotizaciones. Total: {{ $estimates->count() }}</div><!-- /.col-12 -->
			@else
				@php
					$showing = '';
					$first = $estimates->first();
					if($request->has('from') && $request->has('to'))
						$showing .= ' desde <b>"' . $request->input('from') . '"</b> hasta <b>"' . $request->input('to') . '"</b>';
					if($request->has('client_id'))
						$showing .= ' del cliente <b>"' . $first->client->name . '"</b>';
					if($request->has('user_id'))
						$showing .= ' del empleado <b>"' . $first->user->name . '"</b>';
					if($request->has('service_id')){
						$service = \App\Service::find($request->input('service_id'));
						if($service)
							$showing .= ' del servicio <b>"' . $service->title . '"</b>';
					}
					if($request->has('status'))
						$showing .= ' con el estatus <b>"' . $request->input('status') . '"</b>';
				@endphp
				<div class="col-12">Mostrando {{ $estimates->count() }} resultados {!! $showing !!}.</div><!-- /.col-12 -->
			@endif
		@endunless
	</div><!-- /.row -->
	<div class="row">
		<div class="col-12">
			@if ($estimates->isEmpty())
			    <div class="empty">
			        <i class="typcn typcn-coffee"></i>
			        <h2 class="title">No se encontraron cotizaciones</h2><!-- /.title -->
			    </div><!-- /.empty -->
			@else
				<table class="table">
				    <thead>
				        <tr>
				            <th>Folio</th>
				            <th>Fecha</th>
				            <th>Cliente</th>
				            <th>Empleado</th>
				            <th>Servicio</th>
				            <th>Estatus</th>
				            <th>Total</th>
				        </tr>
				    </thead>
				    <tbody>
				        @foreach ($estimates as $estimate)
				        	@php
				        		switch ($estimate->status) {
				        			case 'En espera':
				        				$badge_color = 'yellow';
				        				break;
				        			case 'Vendida':
				        				$badge_color = 'green';
				        				break;
				        			case 'No vendida':
				        				$badge_color = 'red';
				        				break;
				        		}
				        	@endphp
				            <tr>
				                <td data-th="Folio">{{ $estimate->folio }}</td>
				                <td data-th="Fecha">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $estimate->created_at)->diffForHumans()) }}</td>
				                <td data-th="Cliente">{{ $estimate->client->name }}</td>
				                <td data-th="Empleado">{{ $estimate->user->name }}</td>
				                <td data-th="Servicio">{{ $estimate->service }}</td>
				                <td data-th="Estatus">
				                	<span class="badge badge-{{ $badge_color }}">{{ $estimate->status }}</span>
				                </td>
				                <td data-th="Total"><span class="price">${{ number_format((float) $estimate->total, 2, '.', ',') }}</span></td>
				            </tr>
				        @endforeach
				    </tbody>
				</table>
				<!-- /.table -->
			@endif
		</div><!-- /.col-12 -->
	</div><!-- /.row -->
	<div class="row">
	    <div class="col-12">
	        <div class="pagination">
	            {{ $estimates->appends($request->all())->links() }}
	        </div>
	        <!-- /.pagination -->
	    </div>
	    <!-- /.col-12 -->
	</div>
	<!-- /.row -->
@endsection