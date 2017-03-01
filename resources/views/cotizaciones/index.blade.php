@extends('layout.base')

@section('title', 'Cotizaciones')
@section('sectionTitle', 'Cotizaciones')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('cotizaciones/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nueva cotización</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($estimates->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay cotizaciones</h2>
                    <!-- /.title -->
                    <a href="{{ url('cotizaciones/nuevo') }}" class="btn btn-blue">Generar una cotizacion</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Servicio</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estimates as $estimate)
                            <tr>
                                <td data-th="Folio">{{ $estimate->folio }}</td>
                                <td data-th="Fecha">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $estimate->created_at)->diffForHumans()) }}</td>
                                <td data-th="Cliente">{{ $estimate->client->name }}</td>
                                <td data-th="Empleado">{{ $estimate->user->name }}</td>
                                <td data-th="Servicio">{{ $estimate->service }}</td>
                                <td data-th="Total"><span class="price">${{ number_format((float) $estimate->total, 2, '.', ',') }}</span></td>
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
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="pagination">
                {{ $estimates->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
