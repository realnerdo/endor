<div class="row">
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('client_id', 'Cliente', ['class' => 'label']) }}
            {!! Form::select('client_id', $clients, null, ['class' => 'select2-add', 'id' => 'client_id', 'data-placeholder' => 'Selecciona un cliente']) !!}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('phone', 'Teléfono', ['class' => 'label']) }}
            {{ Form::input('text', 'phone', ($estimate->client) ? $estimate->client->phone : null, ['class' => 'input', 'id' => 'phone']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
            {{ Form::input('email', 'email', ($estimate->client) ? $estimate->client->email : null, ['class' => 'input', 'id' => 'email']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('service', 'Servicio', ['class' => 'label']) }}
            {{ Form::input('text', 'service', null, ['class' => 'input', 'id' => 'service', 'required']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
            {{ Form::textarea('description', null, ['size' => '10x3', 'class' => 'input autosizable', 'required']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('status', 'Estatus', ['class' => 'label']) }}
            {{ Form::select('status', $statuses, null, ['class' => 'select2', 'data-placeholder' => 'Estatus']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('discount', 'Con descuento', ['class' => 'label']) }}
            {{ Form::input('text', 'discount', null, ['class' => 'input', 'required']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('total', 'Total (Se calcula automáticamente)', ['class' => 'label']) }}
            {{ Form::input('text', 'total', null, ['class' => 'input', 'required', 'readonly']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <h3 class="title">Servicios</h3><!-- /.title -->
    </div><!-- /.col-12 -->
    <div class="services_list">
        @if($estimate->estimate_services->isEmpty())
            <div class="service row">
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('services[0][title]', 'Título del servicio', ['class' => 'label']) }}
                        {{ Form::select('services[0][title]', $services, null, ['class' => 'select2-add service_title', 'id' => '', 'data-placeholder' => 'Selecciona un servicio', 'required']) }}
                    </div>
                    <!-- /.form-group -->
                </div><!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('services[0][duration]', 'Duración (días)', ['class' => 'label']) }}
                        {{ Form::input('text', 'services[0][duration]', null, ['class' => 'input service_duration', 'id' => '', 'required']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('services[0][offset]', 'Inicio', ['class' => 'label']) }}
                        {{ Form::input('text', 'services[0][offset]', 0, ['class' => 'input service_offset', 'id' => '', 'required']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('services[0][price]', 'Precio', ['class' => 'label']) }}
                        {{ Form::input('text', 'services[0][price]', null, ['class' => 'input service_price', 'id' => '', 'required']) }}
                    </div>
                    <!-- /.form-group -->
                </div><!-- /.col-3 -->
                <div class="col-12">
                    <div class="form-group">
                        {{ Form::label('services[0][content]', 'Contenido', ['class' => 'label']) }}
                        {{ Form::textarea('services[0][content]', null, ['size' => '10x10', 'class' => 'input autosizable service_content', 'id' => '', 'required']) }}
                        {{ Form::hidden('services[0][notes]', null, ['class' => 'service_notes']) }}
                    </div>
                    <!-- /.form-group -->
                </div><!-- /.col-12 -->
            </div><!-- /.service -->
        @else
            @foreach ($estimate->estimate_services as $key => $service)
                <div class="service row">
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][title]', 'Título del servicio', ['class' => 'label']) }}
                            {{ Form::select('services['.$key.'][title]', $services, $service->title, ['class' => 'select2-add service_title', 'id' => '', 'data-placeholder' => 'Selecciona un servicio', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div><!-- /.col-3 -->
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][duration]', 'Duración (días)', ['class' => 'label']) }}
                            {{ Form::input('text', 'services['.$key.'][duration]', $service->duration, ['class' => 'input service_duration', 'id' => '', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col-3 -->
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][offset]', 'Inicio', ['class' => 'label']) }}
                            {{ Form::input('text', 'services['.$key.'][offset]', $service->offset, ['class' => 'input service_offset', 'id' => '', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col-3 -->
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][price]', 'Precio', ['class' => 'label']) }}
                            {{ Form::input('text', 'services['.$key.'][price]', $service->price, ['class' => 'input service_price', 'id' => '', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div><!-- /.col-3 -->
                    <div class="col-12">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][content]', 'Contenido', ['class' => 'label']) }}
                            {{ Form::textarea('services['.$key.'][content]', $service->content, ['size' => '10x10', 'class' => 'input autosizable service_content', 'id' => '', 'required']) }}
                            {{ Form::hidden('services['.$key.'][notes]', $service->notes, ['class' => 'service_notes']) }}
                        </div>
                        <!-- /.form-group -->
                    </div><!-- /.col-12 -->
                    @if($key != 0)
                        <div class="col-12">
                            <button class="btn btn-red delete-service">Eliminar</button>
                        </div><!-- /.col-12 -->
                    @endif
                </div><!-- /.service -->
            @endforeach
        @endif
    </div><!-- /.services_list -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-12">
        <div class="buttons pr">
            <button class="btn btn-blue" id="add-service"><i class="typcn typcn-plus"></i> Añadir otro servicio</button>
            <button type="submit" class="btn btn-green"><i class="typcn typcn-printer"></i> Guardar</button>
        </div>
        <!-- /.tools -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
