<div class="layer" id="send-mail">
    <div class="modal">
        <h3 class="title"><i class="typcn typcn-mail"></i> Enviar Cotización por correo <button class="close-modal"><i class="typcn typcn-times"></i></button></h3>
        <!-- /.title -->
        <div class="content">
            {{ Form::open(['url' => url('cotizaciones/{id}/email'), 'class' => 'form']) }}
                <div class="form-group">
                    {{ Form::label('email', 'Enviar a', ['class' => 'label']) }}
                    {{ Form::input('text', 'email', null, ['class' => 'input']) }}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    {{ Form::label('subject', 'Asunto', ['class' => 'label']) }}
                    {{ Form::input('text', 'subject', $settings->subject, ['class' => 'input']) }}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    {{ Form::label('message', 'Mensaje', ['class' => 'label']) }}
                    {{ Form::textarea('message', $settings->message, ['size' => '30x5', 'class' => 'input autosizable']) }}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    {{ Form::submit('Enviar', ['class' => 'btn btn-green']) }}
                </div>
                <!-- /.form-group -->
            {{ Form::close() }}
        </div>
        <!-- /.content -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.layer -->
