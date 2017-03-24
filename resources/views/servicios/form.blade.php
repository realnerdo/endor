<div class="form-group">
    {{ Form::label('title', 'Título', ['class' => 'label']) }}
    {{ Form::input('text', 'title', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('price', 'Precio', ['class' => 'label']) }}
    {{ Form::input('text', 'price', null, ['class' => 'input']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('content', 'Contenido', ['class' => 'label']) }}
    {{ Form::textarea('content', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('notes', 'Cláusulas de contratación', ['class' => 'label']) }}
    {{ Form::textarea('notes', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('clientes'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
