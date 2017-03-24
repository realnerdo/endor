$(function(){
    var $body = $('body');
    var base_url = window.location.origin;

    // dropdown
    var dropdown = $('.dropdown');
    if(dropdown.length){
        $(window).click(function() {
            dropdown.find('.list').removeClass('open');
        });
        $body.on('click', '.dropdown', function(e){
            if ($(e.target).hasClass('link'))
                return true;
            var list = $(this).find('.list');
            list.addClass('open');
            return false;
        });
    }

    // Select2
    var selectable = $('.select2');
    if(selectable.length){
        selectable.select2({
            width: '100%',
            language: 'es'
        });
    }

    var selectable_add = $('.select2-add');
    if(selectable_add.length){
        selectable_add.select2({
            width: '100%',
            language: 'es',
            tags: true,
            selectOnClose: true
        });
    }

    // Datepicker
    var dateable = $('.datepicker');
    if(dateable.length){
        var start = (dateable.hasClass('whenever')) ? null : new Date();
        dateable.datepicker({
            language: 'es-ES',
            format: 'yyyy-mm-dd',
            startDate: start,
            autoHide: true
        });
    }

    // Autosize
    var autosizable = $('.autosizable');
    if(autosizable.length){
        autosize(autosizable);
    }

    // Modal
    var modal = $('.modal');
    if(modal.length){

        function show_modal(modal_id, resource_id) {
            var modal = $('#'+modal_id);
            if(modal_id == 'client-modal'){
                $.get(base_url + '/clientes/getClientById/'+resource_id, function(data){
                    var p_name = $('<p>', {
                            html: '<b>Nombre:</b> '+data.name
                        }),
                        p_phone = $('<p>', {
                            html: '<b>Teléfono:</b> '+data.phone
                        }),
                        p_email = $('<p>', {
                            html: '<b>Correo electrónico:</b> <a class="link" href="mailto:'+ data.email +'">'+data.email+'</a>'
                        }),
                        p_estimates = $('<p>', {
                            html: '<b>Cotizaciones:</b> <a class="link" href="'+ base_url + '/reportes?client_id='+ data.id +'">'+data.estimates.length+'</a>'
                        });
                    var content = modal.find('.content');
                    content.empty();
                    content.append(p_name);
                    content.append(p_phone);
                    content.append(p_email);
                    content.append(p_estimates);
                    console.log(data);
                    modal.addClass('show');
                });
            }
        }

        function close_modal(){
            var modal = $('.layer');
            modal.removeClass('show');
        }

        $body.on('click', '.modal-trigger', function(){
            var $this = $(this),
                modal_id = $this.data('modal'),
                resource_id = $this.data('id');
            show_modal(modal_id, resource_id);
            return false;
        });

        $body.on('click', '.close-modal', function(){
            close_modal();
            return false;
        });

        $body.on('click', '.layer', function(e){
            if (e.target == this){
                close_modal();
            }
        });

        $(document).keyup(function(e) {
          if (e.keyCode === 27) close_modal();
        });
    }

    // Change status
    var change_status_form = $('.change-status-form');
    if(change_status_form.length){
        $body.on('change', '.change-status', function(){
            var $this = $(this),
                status = $this.val(),
                form = $this.closest('.change-status-form'),
                data = form.serialize(),
                action = form.attr('action');

            $.post(action, data, function(result){
                if(result == 'success'){
                    location.reload();
                }
            });
        });
    }

    // Cotizador
    var select_client_id = $('#client_id');
    if(select_client_id.length){
        var client_id = $('#client_id'),
            phone = $('#phone'),
            email = $('#email');

        client_id.on('change', function(){
            var id = $(this).val();
            $.get(base_url+'/clientes/getClientById/'+id, function(data){
                phone.val(data.phone);
                email.val(data.email);
            });
        });

        function calculate_total(){
            var input_total = $('#total'),
                input_prices = $('.service_price'),
                total = 0;

            input_prices.each(function(){
                var $this = $(this),
                    price = ($this.val() != '') ? parseFloat($this.val()) : 0;

                total = total + price;
            });

            input_total.val(total);
        }

        $body.on('change', '.service_title', function(){
            var $this = $(this),
                title = $this.val(),
                input_price = $this.closest('.service').find('.service_price'),
                textarea_content = $this.closest('.service').find('.service_content'),
                hidden_notes = $this.closest('.service').find('.service_notes');
            $.get(base_url+'/servicios/getServiceByTitle/'+title, function(data){
                input_price.val(data.price);
                textarea_content.val(data.content);
                hidden_notes.val(data.notes);
                calculate_total();
            });
        });

        $body.on('keyup', '.service_price', function(){
            calculate_total();
        });

        $body.on('change', '#with_discount', function(){
            var input_discount = $('#discount');
            if($(this).prop('checked')){
                input_discount.prop('disabled', false);
            }else{
                input_discount.prop('disabled', true);
                input_discount.val('');
            }
        });

        function add_service_form(){
            var services_list = $('.services_list');

            var service_form = services_list.find('.service').first();
            var cloned = service_form.clone().find('input:text').val('').end().find('textarea').val('').end();
            var select2_old = cloned.find('.select2-container');

            select2_old.remove();

            var selectable_add = cloned.find('.select2-add');
            selectable_add.select2({
                width: '100%',
                language: 'es',
                tags: true,
                selectOnClose: true
            });
            var div_delete = $('<div>', {
                class: 'col-12',
                html: $('<button>', {
                    text: 'Eliminar',
                    class: 'btn btn-red delete-service'
                })
            });
            cloned.append(div_delete);

            cloned.appendTo(services_list);

            var services_count = parseInt($('.service').length);

            var inputs = cloned.find('[name^="services[0]"]');
            inputs.each(function(){
                var $this = $(this),
                    input_name = $this.attr('name'),
                    new_name = input_name.replace('[0]', '['+(services_count - 1)+']');

                $this.attr('name', new_name);
            });
        }

        var add_service = $('#add-service');
        add_service.click(function(){
            add_service_form();
            return false;
        });

        $body.on('click', '.delete-service', function(){
            var service = $(this).closest('.service').remove();
        });
    }

    // Notifications
    var notification = $('.notification');
    if(notification.length){
        notification.delay(4000).slideUp();
        $body.on('click', '.close-notification', function(){
            notification.slideUp();
        });
    }
});
