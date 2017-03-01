@extends('layout.base')

@section('title', 'Clientes')
@section('sectionTitle', 'Agregar nuevo cliente')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($client = new \App\Client, ['url' => 'clientes', 'class' => 'form']) }}
                @include('clientes.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
