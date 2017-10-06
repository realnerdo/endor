@extends('layout.base')

@section('title', 'Clientes')
@section('sectionTitle', 'Clientes')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('clientes/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nuevo cliente</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($clients->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay clientes</h2>
                    <!-- /.title -->
                    <a href="{{ url('clientes/nuevo') }}" class="btn btn-blue">Agregar un cliente</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Fecha de registro</th>
                            <th>Cotizaciones</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td data-th="Nombre">{{ $client->name }}</td>
                                <td data-th="Empresa">{{ $client->company }}</td>
                                <td data-th="Correo electrónico"><a href="mailto:{{ $client->email }}" class="link">{{ $client->email }}</a></td>
                                <td data-th="Teléfono">{{ $client->phone }}</td>
                                <td data-th="Fecha de registro">{{ $client->created_at }}</td>
                                <td data-th="Cotizaciones"><a href="{{ url('cotizaciones') }}" class="link">{{ $client->estimates()->count() }}</a></td>
                                <td data-th="Opciones">
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('clientes/'.$client->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones') }}" class="link"><i class="typcn typcn-clipboard"></i> Cotizaciones</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('clientes', $client->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
                {{ $clients->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('modal')
    <div class="layer" id="upload-excel-modal">
        <div class="modal">
            <h3 class="title"><i class="typcn typcn-storage"></i> Subir archivo <button class="close-modal"><i class="typcn typcn-times"></i></button></h3>
            <!-- /.title -->
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <p>Asegúrate que los títulos de las columnas sean:</p>
                        <p><b>name, email, phone</b></p>
                    </div>
                    <!-- /.col-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        {{ Form::open(['url' => url('clientes/importClients'), 'files' => true,'class' => 'form']) }}
                            <div class="form-group">
                                {{ Form::label('file', 'Selecciona un archivo .xsl, .xlsx o .csv', ['class' => 'label']) }}
                                {{ Form::file('file', ['required']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::submit('Cargar clientes', ['class' => 'btn btn-green']) }}
                            </div>
                            <!-- /.form-group -->
                        {{ Form::close() }}
                    </div>
                    <!-- /.col-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.layer -->
@endsection
