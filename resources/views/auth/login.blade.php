@extends('layout.base')

@section('auth')

<main class="auth">
    {{ Form::open(['url' => '/login', 'class' => 'login-form auth-form']) }}
        <h1 class="title">Iniciar sesión</h1>
        <!-- /.title -->
        @include('layout.errors')
        <div class="form-group">
            {{ Form::label('username', 'Usuario', ['class' => 'label']) }}
            {{ Form::input('text', 'username', old('username'), ['required', 'autofocus', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('password', 'Contraseña', ['class' => 'label']) }}
            {{ Form::input('password', 'password', null, ['required', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::checkbox('remember') }}
            {{ Form::label('remember', 'Recuérdame') }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::submit('Entrar', ['class' => 'btn btn-green']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Html::link(url('/password/reset'), '¿Olvidaste tu contraseña?', ['class' => 'link']) }}
        </div>
        <!-- /.form-group -->
    {{ Form::close() }}
</main>
<!-- /.auth -->

@endsection
