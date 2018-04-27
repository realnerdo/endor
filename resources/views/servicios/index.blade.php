@extends('layout.base')

@section('title', 'Servicios')
@section('sectionTitle', 'Servicios')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('servicios/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nuevo servicio</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($services->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay servicios</h2>
                    <!-- /.title -->
                    <a href="{{ url('servicios/nuevo') }}" class="btn btn-blue">Agregar un servicio</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td data-th="Título">{{ $service->title }}</td>
                                <td data-th="Opciones">
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('servicios/'.$service->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones?service_title='.$service->title) }}" class="link"><i class="typcn typcn-clipboard"></i> Cotizaciones</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('servicios', $service->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
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
                {{ $services->links() }}
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
