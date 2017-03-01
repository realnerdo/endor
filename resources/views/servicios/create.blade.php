@extends('layout.base')

@section('title', 'Servicios')
@section('sectionTitle', 'Agregar nuevo servicio')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($service = new \App\Service, ['url' => 'servicios', 'class' => 'form']) }}
                @include('servicios.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
