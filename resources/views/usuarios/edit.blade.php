@extends('layout.base')

@section('title', 'Usuarios')
@section('sectionTitle', 'Editar datos del usuario')

@section('content')
    <div class="row">
        <div class="col-6">
            @include('layout.errors')
            {{ Form::model($user, ['url' => url('usuarios', $user->id), 'class' => 'form', 'files' => true, 'method' => 'PATCH']) }}
                @include('usuarios.form')
            {{ Form::close() }}
        </div>
        <!-- /.col-6 -->
    </div>
    <!-- /.row -->
@endsection
