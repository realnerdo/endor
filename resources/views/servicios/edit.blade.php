@extends('layout.base')

@section('title', 'Servicios')
@section('sectionTitle', 'Editar datos del servicio')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($service, ['url' => url('servicios', $service->id), 'class' => 'form', 'method' => 'PATCH']) }}
                @include('servicios.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
