@extends('layout.base')

@section('title', 'Clientes')
@section('sectionTitle', 'Editar datos del cliente')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($client, ['url' => url('clientes', $client->id), 'class' => 'form', 'method' => 'PATCH']) }}
                @include('clientes.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
