@extends('layout.base')

@section('title', 'Cotizaciones')
@section('sectionTitle', 'Editar cotización')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('layout.errors')
            {{ Form::model($estimate, ['url' => url('cotizaciones', $estimate->id), 'class' => 'estimate_form form', 'method' => 'PATCH']) }}
                @include('cotizaciones.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
