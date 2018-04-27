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
					{{ Form::label('from', 'Desde fecha', ['class' => 'label']) }}
					{{ Form::input('text', 'from', ($request->has('from')) ? $request->input('from') : null, ['class' => 'input datepicker whenever']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('to', 'Hasta fecha', ['class' => 'label']) }}
					{{ Form::input('text', 'to', ($request->has('to')) ? $request->input('to') : null, ['class' => 'input datepicker whenever']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('price_from', 'Desde precio', ['class' => 'label']) }}
					{{ Form::input('text', 'price_from', ($request->has('price_from')) ? $request->input('price_from') : null, ['class' => 'input']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('price_to', 'Hasta precio', ['class' => 'label']) }}
					{{ Form::input('text', 'price_to', ($request->has('price_to')) ? $request->input('price_to') : null, ['class' => 'input']) }}
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
					{{ Form::label('company', 'Empresa', ['class' => 'label']) }}
					{{ Form::select('company', $companies, ($request->has('company')) ? $request->input('company') : null, ['class' => 'select2', 'data-placeholder' => 'Empresa']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('user_id', 'Ejecutivo', ['class' => 'label']) }}
					{{ Form::select('user_id', $users, ($request->has('user_id')) ? $request->input('user_id') : null, ['class' => 'select2', 'data-placeholder' => 'Ejecutivo']) }}
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
			<div class="col-3">
				<div class="form-group">
					{{ Form::label('submit', 'Filtrar', ['class' => 'label']) }}
					{{ Form::submit('Aceptar', ['class' => 'btn btn-green']) }}
				</div><!-- /.form-group -->
			</div><!-- /.col-3 -->
		{{ Form::close() }}
	</div><!-- /.row -->
	<div class="row">
		@unless($estimates->isEmpty())
			@if($values == '')
				<div class="col-12">Resultados: <b>{{ $estimates->total() }}</b>. Mostrando todas las cotizaciones.</div><!-- /.col-12 -->
			@else
				@php
					$showing = '';
					$first = $estimates->first();
					if($request->has('from'))
						$showing .= ' desde <b>"' . $request->input('from') . '"</b>';
					else
						$showing .= ' desde <b>la primera cotización</b>';
					if($request->has('to'))
						$showing .= ' hasta <b>"' . $request->input('to') . '"</b>';
					else
						$showing .= ' hasta <b>hoy ("'. \Carbon\Carbon::today()->toDateString() .'")</b>';
					if($request->has('price_from'))
						$showing .= ' desde <b>$'. number_format($request->input('price_from'), 2, '.', ',') . '</b>';
					if($request->has('price_to'))
						$showing .= ' hasta <b>$'. number_format($request->input('price_to'), 2, '.', ',') . '</b>';
					if($request->has('client_id'))
						$showing .= ' del cliente <b>"' . $first->client->name . '"</b>';
					if($request->has('company'))
						$showing .= ' de la empresa <b>"' . $request->input('company') . '"</b>';
					if($request->has('user_id'))
						$showing .= ' del ejecutivo <b>"' . $first->user->name . '"</b>';
					if($request->has('service_title')){
						$service = \App\Service::where('title', $request->input('service_title'))->first();
						if($service)
							$showing .= ' del servicio <b>"' . $service->title . '"</b>';
					}
					if($request->has('status'))
						$showing .= ' con el estatus <b>"' . $request->input('status') . '"</b>';
				@endphp
				<div class="col-12">Resultados: <b>{{ $estimates->total() }}</b> {!! $showing !!}.</div><!-- /.col-12 -->
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
				<table class="table report-totals">
                    <thead>
                        <tr>
                            <th>Total Vendido</th>
                            <th>Total No vendido</th>
                            <th>Total por vender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-th="Total Vendido"><span class="price">${{ number_format((float) $selled_total, 2, '.', ',') }}</span></td>
                            <td data-th="Total No vendido"><span class="price">${{ number_format((float) $not_selled_total, 2, '.', ',') }}</span></td>
                            <td data-th="Total por vender"><span class="price">${{ number_format((float) $pending_total, 2, '.', ',') }}</span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- /.table -->

				<table class="table">
				    <thead>
				        <tr>
				            <th>Folio</th>
				            <th>Fecha</th>
				            <th>Cliente</th>
				            <th>Empresa</th>
				            <th>Ejecutivo</th>
				            <th>Servicio</th>
				            <th>Estatus</th>
				            <th>Total</th>
				            <th>Opciones</th>
				        </tr>
				    </thead>
				    <tbody>
                        @php
                            $request->request->remove('status');
                        @endphp
				        @foreach ($estimates as $estimate)
				        	@php
				        		switch ($estimate->status) {
				        			case 'En espera':
				        				$badge_color = 'yellow';
				        				break;
				        			case 'Vendida':
				        				$badge_color = 'green';
				        				break;
				        			case 'Vendida con descuento':
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
				                <td data-th="Cliente">
									<a href="#" class="modal-trigger link" data-modal="client-modal" data-id="{{ $estimate->client->id }}">{{ $estimate->client->name }}</a>
								</td>
						<td data-th="Empresa">{{ $estimate->client->company  }}</td>
				                <td data-th="Ejecutivo">{{ $estimate->user->name }}</td>
				                <td data-th="Servicio">{{ $estimate->service }}</td>
                                <td data-th="Estatus">
                                    @if (!$estimate->discount)
                                        @php
                                            unset($statuses['Vendida con descuento']);
                                        @endphp
                                    @else
                                        @php
                                            $statuses['Vendida con descuento'] = 'Vendida con descuento';
                                        @endphp
                                    @endif
                                    @php
                                        unset($statuses[0]);
                                    @endphp
                                    {{ Form::open(['url' => 'cotizaciones/' . $estimate->id . '/changeStatus', 'class' => 'change-status-form']) }}
                                        {{ Form::select('status', $statuses, $estimate->status, ['class' => 'select2 change-status', 'data-placeholder' => 'Cambiar estatus']) }}
                                    {{ Form::close() }}
                                </td>
				                <td data-th="Total">
									@if ($estimate->discount)
										<span class="price discount"><i class="typcn typcn-tag"></i>${{ number_format((float) $estimate->discount, 2, '.', ',') }}</span>
	                                    <br>
									@endif
                                    <span class="price">${{ number_format((float) $estimate->total, 2, '.', ',') }}</span>
								</td>
                                <td data-th="Opciones">
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/download') }}" class="link"><i class="typcn typcn-download"></i> Descargar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones/'.$estimate->id.'/pdf') }}" class="link" target="_blank"><i class="typcn typcn-printer"></i> Imprimir</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="#" class="link modal-trigger" data-modal="send-mail" data-id="{{ $estimate->id }}" data-email="{{ $estimate->client->email }}"><i class="typcn typcn-mail"></i> Enviar correo</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('cotizaciones', $estimate->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
                                                    <button type="submit" class="link"><i class="typcn typcn-delete"></i> Eliminar</button>
                                                {{ Form::close() }}
                                            </li>
                                            <!-- /.item -->
                                        </ul>
                                        <!-- /.list -->
                                    </span><!-- /.dropdown -->
                                </td>
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

@section('modal')
	@include('clientes.modal')
@endsection
