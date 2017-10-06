<div class="form-group">
    {{ Form::label('name', 'Nombre', ['class' => 'label']) }}
    {{ Form::input('text', 'name', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('company', 'Empresa', ['class' => 'label']) }}
    {{ Form::input('text', 'company', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
    {{ Form::input('email', 'email', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('phone', 'Teléfono', ['class' => 'label']) }}
    {{ Form::input('text', 'phone', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('clientes'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
