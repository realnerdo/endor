<div class="form-group">
    {{ Form::label('logo', 'Logotipo', ['class' => 'label']) }}
    @if (isset($setting->logo->url))
        <div class="picture">
            {{ Html::image(asset('storage/'.$setting->logo->url), $setting->title, ['class' => 'img']) }}
        </div>
        <!-- /.picture -->
    @endif
    {{ Form::file('logo', ['class' => 'file']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('company', 'Nombre de la compañía', ['class' => 'label']) }}
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
    {{ Form::label('address', 'Dirección', ['class' => 'label']) }}
    {{ Form::textarea('address', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('bank_details', 'Datos bancarios', ['class' => 'label']) }}
    {{ Form::textarea('bank_details', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::label('estimate_description', 'Descripción de cotización', ['class' => 'label']) }}
    {{ Form::textarea('estimate_description', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('/'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
