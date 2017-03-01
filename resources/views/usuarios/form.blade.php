<div class="form-group">
    {{ Form::label('name', 'Nombre', ['class' => 'label']) }}
    {{ Form::input('text', 'name', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('username', 'Usuario', ['class' => 'label']) }}
    {{ Form::input('text', 'username', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
    {{ Form::input('email', 'email', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('password', 'Contraseña', ['class' => 'label']) }}
    {{ Form::input('password', 'password', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('password_confirmation', 'Confirmar contraseña', ['class' => 'label']) }}
    {{ Form::input('password', 'password_confirmation', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('role', 'Rol', ['class' => 'label']) }}
    {{ Form::select('role', $roles, null, ['class' => 'select2']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('clientes'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
