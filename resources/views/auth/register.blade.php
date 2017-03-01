@extends('layout.base')

@section('auth')

<main class="auth">
    {{ Form::open(['url' => '/register', 'class' => 'register-form auth-form', 'files' => true]) }}
        <h1 class="title">Registrase</h1>
        <!-- /.title -->
        @include('layout.errors')
        <div class="form-group">
            {{ Form::label('name', 'Nombre', ['class' => 'label']) }}
            {{ Form::input('text', 'name', old('name'), ['required', 'autofocus', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('name', 'Usuario', ['class' => 'label']) }}
            {{ Form::input('text', 'username', old('username'), ['required', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
            {{ Form::input('email', 'email', old('email'), ['required', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('password', 'Contraseña', ['class' => 'label']) }}
            {{ Form::input('password', 'password', null, ['required', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('password-confirm', 'Confirmar contraseña', ['class' => 'label']) }}
            {{ Form::input('password', 'password_confirmation', null, ['required', 'class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('sidebar_logo', 'Logotipo del sitio', ['class' => 'label']) }}
            {{ Form::file('sidebar_logo', ['class' => 'file']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('estimate_logo', 'Logotipo del PDF', ['class' => 'label']) }}
            {{ Form::file('estimate_logo', ['class' => 'file']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('title', 'Nombre del negocio', ['class' => 'label']) }}
            {{ Form::input('text', 'title', null, ['class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('store_url', 'URL de la tienda', ['class' => 'label']) }}
            {{ Form::input('text', 'store_url', null, ['class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('observations', 'Observaciones', ['class' => 'label']) }}
            {{ Form::textarea('observations', null, ['size' => '10x3', 'class' => 'input autosizable']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('phone', 'Teléfono', ['class' => 'label']) }}
            {{ Form::input('text', 'phone', null, ['class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('address', 'Dirección', ['class' => 'label']) }}
            {{ Form::input('text', 'address', null, ['class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::label('tax', 'I.V.A.', ['class' => 'label']) }}
            {{ Form::input('text', 'tax', null, ['class' => 'input']) }}
        </div>
        <!-- /.form-group -->
        <div class="form-group">
            {{ Form::submit('Registrar', ['class' => 'btn btn-green']) }}
        </div>
        <!-- /.form-group -->
    {{ Form::close() }}
</main>
<!-- /.auth -->
@endsection
