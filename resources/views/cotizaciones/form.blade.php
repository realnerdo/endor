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
</div><!-- /.row -->
<div class="row">
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('payment_type', 'Tipo de inversión', ['class' => 'label']) }}
            {{ Form::select('payment_type', $payment_types, null, ['class' => 'select2', 'data-placeholder' => 'Inversión']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('status', 'Estatus', ['class' => 'label']) }}
            {{ Form::select('status', $statuses, null, ['class' => 'select2', 'data-placeholder' => 'Estatus']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::checkbox('with_discount', null, ($estimate->discount) ? true : false, ['id' => 'with_discount']) }}
            {{ Form::label('discount', 'Con descuento', ['class' => 'label inline']) }}
            @php
                $has_discount = ($estimate->discount) ? '' : 'disabled';
            @endphp
            {{ Form::input('text', 'discount', null, ['class' => 'input', 'required', $has_discount, 'id' => 'discount']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('total', 'Total (Se calcula automáticamente)', ['class' => 'label']) }}
            {{ Form::input('text', 'total', null, ['class' => 'input', 'required', 'readonly']) }}
        </div><!-- /.form-group -->
    </div><!-- /.col-3 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-3">
        <div class="form-group">
            {{ Form::label('origin', 'Origen', ['class' => 'label']) }}
            {!! Form::select('origin', $origins, null, ['class' => 'select2', 'data-placeholder' => 'Origen']) !!}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-3 -->
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('description', 'Descripción', ['class' => 'label']) }}
            {{ Form::textarea('description', (isset($setting)) ? $setting->estimate_description : null, ['size' => '10x3', 'class' => 'input autosizable', 'required']) }}
        </div>
        <!-- /.form-group -->
    </div>
    <!-- /.col-12 -->
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
                        {{ Form::input('number', 'services[0][duration]', 0, ['class' => 'input service_duration', 'id' => '', 'required']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-3 -->
                <div class="col-3">
                    <div class="form-group">
                        {{ Form::label('services[0][offset]', 'Día de inicio', ['class' => 'label']) }}
                        {{ Form::input('number', 'services[0][offset]', 0, ['class' => 'input service_offset', 'id' => '', 'required']) }}
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
			{{ Form::label('services[0][notes]', 'Cláusulas de contratación', ['class' => 'label']) }}
			{{ Form::textarea('services[0][notes]', null, ['size' => '10x10', 'class' => 'input autosizable service_notes']) }}
		    </div>
		    <!-- /.form-group -->
		</div><!-- /.col-12 -->
                <div class="row">
                    <div class="col-12">
                        <h3 class="title">Secciones</h3><!-- /.title -->
                    </div>
                    <!-- /.col-12 -->
                    <div class="sections_list"></div>
                    <!-- /.sections_list -->
                    <div class="col-12">
                        <div class="buttons pr">
                            <button type="button" class="btn btn-blue add-section"><i class="typcn typcn-plus"></i> Añadir otra sección</button>
                        </div>
                        <!-- /.buttons pr -->
                    </div>
                    <!-- /.col-12 -->
                </div>
                <!-- /.row -->
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
                            {{ Form::input('number', 'services['.$key.'][duration]', $service->duration, ['class' => 'input service_duration', 'id' => '', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col-3 -->
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][offset]', 'Día de inicio', ['class' => 'label']) }}
                            {{ Form::input('number', 'services['.$key.'][offset]', $service->offset, ['class' => 'input service_offset', 'id' => '', 'required']) }}
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
			    {{ Form::label('services['.$key.'][notes]', 'Cláusulas de contratación', ['class' => 'label']) }}
			    {{ Form::textarea('services['.$key.'][notes]', $service->notes, ['size' => '10x10', 'class' => 'input autosizable service_notes']) }}
			</div>
			<!-- /.form-group -->
		    </div><!-- /.col-12 -->
                    <div class="row">
                        <div class="col-12">
                            <h3 class="title">Secciones</h3><!-- /.title -->
                        </div>
                        <!-- /.col-12 -->
                        <div class="sections_list">
                            @foreach ($service->estimate_sections as $k => $section)
                                <div class="section row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{ Form::label('services[' . $key . '][sections][' . $k . '][title]', 'Título', ['class' => 'label']) }}
                                            {{ Form::input('text', 'services[' . $key . '][sections][' . $k . '][title]', $section->title, ['class' => 'input']) }}
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            {{ Form::label('services[' . $key . '][sections][' . $k . '][content]', 'Contenido', ['class' => 'label']) }}
                                            {{ Form::textarea('services[' . $key . '][sections][' . $k . '][content]', $section->content, ['size' => '30x8', 'class' => 'input autosizable']) }}
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-12 -->
                                    @if($k != 0)
                                        <div class="col-12">
                                            <button type="button" class="btn btn-red delete-section">Eliminar sección</button>
                                        </div><!-- /.col-12 -->
                                    @endif
                                </div>
                                <!-- /.section row -->
                            @endforeach
                        </div>
                        <!-- /.sections_list -->
                        <div class="col-12">
                            <div class="buttons pr">
                                <button type="button" class="btn btn-blue add-section"><i class="typcn typcn-plus"></i> Añadir otra sección</button>
                            </div>
                            <!-- /.buttons pr -->
                        </div>
                        <!-- /.col-12 -->
                    </div>
                    <!-- /.row -->
                    {{-- <div class="col-12">
                        <div class="form-group">
                            {{ Form::label('services['.$key.'][content]', 'Contenido', ['class' => 'label']) }}
                            {{ Form::textarea('services['.$key.'][content]', $service->content, ['size' => '10x10', 'class' => 'input autosizable service_content', 'id' => '', 'required']) }}
                        </div>
                        <!-- /.form-group -->
                    </div><!-- /.col-12 --> --}}
                    @if($key != 0)
                        <div class="col-12">
                            <button type="button" class="btn btn-red delete-service">Eliminar servicio</button>
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
            <button type="button" class="btn btn-blue" id="add-service"><i class="typcn typcn-plus"></i> Añadir otro servicio</button>
            <button type="submit" class="btn btn-green"><i class="typcn typcn-printer"></i> Guardar</button>
        </div>
        <!-- /.tools -->
    </div>
    <!-- /.col-12 -->
</div>
<!-- /.row -->
