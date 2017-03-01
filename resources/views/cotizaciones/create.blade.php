@extends('layout.base')

@section('title', 'Cotizaciones')
@section('sectionTitle', 'Generar nueva cotización')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('layout.errors')
            {{ Form::model($estimate = new \App\Estimate, ['url' => 'cotizaciones', 'class' => 'estimate_form form']) }}
                @include('cotizaciones.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
