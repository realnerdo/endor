@extends('layout.base')

@section('title', 'Correos enviados')
@section('sectionTitle', 'Correos enviados')

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($emails->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no se han enviado correos</h2>
                    <!-- /.title -->
                    <a href="{{ url('cotizaciones') }}" class="btn btn-blue">Ir a Cotizaciones</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Enviado a</th>
                            <th>Asunto</th>
                            <th>Mensaje</th>
                            <th>Fecha de apertura</th>
                            <th>Fecha de envío</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emails as $email)
                            @php
                                $opened_at = (is_null($email->opened_at)) ? 'Sin abrir' : $email->opened_at;
                            @endphp
                            <tr>
                                <td data-th="Enviado a">{{ $email->to }}</td>
                                <td data-th="Asunto">{{ $email->subject }}</td>
                                <td data-th="Mensaje">{{ $email->message }}</td>
                                <td data-th="Fecha de apertura">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $opened_at)->diffForHumans()) }}</td>
                                <td data-th="Fecha de envío">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $email->created_at)->diffForHumans()) }}</td>
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
                {{ $emails->links() }}
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
