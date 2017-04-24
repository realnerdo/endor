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

<div class="row">
    <div class="col-12">
        <h3 class="title">Secciones</h3><!-- /.title -->
    </div>
    <!-- /.col-12 -->
    <div class="sections_list">
        @if($service->sections->isEmpty())
            <div class="section row">
                <div class="col-12">
                    <div class="form-group">
                        {{ Form::label('sections[0][title]', 'Título', ['class' => 'label']) }}
                        {{ Form::input('text', 'sections[0][title]', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        {{ Form::label('sections[0][content]', 'Contenido', ['class' => 'label']) }}
                        {{ Form::textarea('sections[0][content]', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.section row -->
        @else
            @foreach ($service->sections as $key => $section)
                <div class="section row">
                    <div class="col-12">
                        <div class="form-group">
                            {{ Form::label('sections[' . $key . '][title]', 'Título', ['class' => 'label']) }}
                            {{ Form::input('text', 'sections[' . $key . '][title]', $section->title, ['class' => 'input']) }}
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            {{ Form::label('sections[' . $key . '][content]', 'Contenido', ['class' => 'label']) }}
                            {{ Form::textarea('sections[' . $key . '][content]', $section->content, ['size' => '30x5', 'class' => 'input autosizable']) }}
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col-12 -->
                    @if($key != 0)
                        <div class="col-12">
                            <button class="btn btn-red delete-section">Eliminar</button>
                        </div><!-- /.col-12 -->
                    @endif
                </div>
                <!-- /.section row -->
            @endforeach
        @endif

    </div>
    <!-- /.sections_list -->

    <div class="col-12">
        <div class="buttons pr">
            <button class="btn btn-blue add-section"><i class="typcn typcn-plus"></i> Añadir otra sección</button>
        </div>
        <!-- /.buttons pr -->
    </div>
    <!-- /.col-12 -->

</div>
<!-- /.row -->

<div class="form-group">
    {{ Form::label('notes', 'Cláusulas de contratación', ['class' => 'label']) }}
    {{ Form::textarea('notes', null, ['size' => '30x5', 'class' => 'input autosizable']) }}
</div>
<!-- /.form-group -->
<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-green']) }}
    {{ Html::link(url('servicios'), 'Cancelar', ['class' => 'btn btn-red']) }}
</div>
<!-- /.form-group -->
