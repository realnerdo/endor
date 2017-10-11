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

        function show_modal(modal_id, resource_id, client_email) {
            var modal = $('#'+modal_id),
                form = modal.find('.form'),
                action = (form.length) ? form.attr('action') : null,
                action_id = (action) ? action.replace('{id}', resource_id) : null;

            if(form.length)
                form.attr('action', action_id);
            if(client_email){
                $('#send-mail').find('input[name="email"]').val(client_email);
            }

            if(modal_id == 'client-modal'){
                $.get(base_url + '/clientes/getClientById/'+resource_id, function(data){
                    var p_name = $('<p>', {
                            html: '<b>Nombre:</b> '+data.name
                        }),
                        p_company = $('<p>', {
                            html: '<b>Empresa:</b> '+data.company
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
                    content.append(p_company);
                    content.append(p_phone);
                    content.append(p_email);
                    content.append(p_estimates);
                });
            }

            modal.addClass('show');
        }

        function close_modal(){
            var modal = $('.layer');
            modal.removeClass('show');

            var form = modal.find('.form');
            if(form.length){
                var action = form.attr('action'),
                    action_wildcard = action.replace(/\d+/g, '{id}');
                form.attr('action', action_wildcard);
                form[0].reset();
            }
        }

        $body.on('click', '.modal-trigger', function(){
            var $this = $(this),
                modal_id = $this.data('modal'),
                resource_id = $this.data('id'),
                client_email = ($this[0].hasAttribute('data-email')) ? $this.data('email') : null;
            show_modal(modal_id, resource_id, client_email);
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

        function add_estimate_sections(sections, sections_list, index){

            sections_list.empty();

            for (var i = 0; i < sections.length; i++) {
                var section_div = $('<div>', {
                        class: 'section row'
                    }),
                    col_section_div = $('<div>', { class: 'col-12' }),
                    title_form_group_div = $('<div>', { class: 'form-group' }),
                    title_label = $('<label>', {
                        class: 'label',
                        id: 'services[' + index + '][sections][' + i + '][title]',
                        text: 'Título'
                    }),
                    title_input = $('<input>', {
                        type: 'text',
                        class: 'input',
                        name: 'services[' + index + '][sections][' + i + '][title]',
                        value: sections[i].title
                    }),
                    content_form_group_div = $('<div>', { class: 'form-group' }),
                    content_label = $('<label>', {
                        class: 'label',
                        id: 'services[' + index + '][sections][' + i + '][content]',
                        text: 'Contenido'
                    }),
                    content_textarea = $('<textarea>', {
                        class: 'input autosizable',
                        cols: '30',
                        rows: '8',
                        name: 'services[' + index + '][sections][' + i + '][content]',
                        text: sections[i].content
                    }),
                    col_delete_div = $('<div>', {
                        class: 'col-12',
                        html: $('<button>', {
                            class: 'btn btn-red delete-section',
                            text: 'Eliminar sección'
                        })
                    });

                autosize(content_textarea);

                title_form_group_div.append(title_label);
                title_form_group_div.append(title_input);

                content_form_group_div.append(content_label);
                content_form_group_div.append(content_textarea);

                col_section_div.append(title_form_group_div);
                col_section_div.append(content_form_group_div);

                section_div.append(col_section_div);

                if(i != 0){
                    section_div.append(col_delete_div);
                }

                sections_list.append(section_div);
            }

        }

        $body.on('change', '.service_title', function(){
            var $this = $(this),
                title = $this.val(),
                input_price = $this.closest('.service').find('.service_price'),
                input_price_name = input_price.attr('name'),
                name = input_price_name.replace('services[', ''),
                index = name.replace('][price]', ''),
                // textarea_content = $this.closest('.service').find('.service_content'),
                input_notes = $this.closest('.service').find('.service_notes'),
                sections_list = $this.closest('.service').find('.sections_list');


            $.get(base_url+'/servicios/getServiceByTitle/'+title, function(data){
                input_price.val(data.price);
                // // textarea_content.val(data.content);
		input_notes.val(data.notes);
                add_estimate_sections(data.sections, sections_list, index);
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
            var sections_list = cloned.find('.sections_list');

            sections_list.empty();
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
                    text: 'Eliminar servicio',
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

    // Services
    var sections_list = $('.sections_list');
    if(sections_list.length){

        function add_section_form(sections_list){

            var section_form = sections_list.find('.section').first();
            var cloned = section_form.clone().find('input:text').val('').end().find('textarea').val('').end();

            var div_delete = $('<div>', {
                class: 'col-12',
                html: $('<button>', {
                    text: 'Eliminar sección',
                    class: 'btn btn-red delete-section'
                })
            });
            cloned.append(div_delete);

            cloned.appendTo(sections_list);

            var sections_count = parseInt($('.section').length);

            var services_list = $('.services_list');
            if(services_list.length){
                var inputs = cloned.find('[name*="[sections][0]"]');
                inputs.each(function(){
                    var $this = $(this),
                        input_name = $this.attr('name'),
                        new_name = input_name.replace('[sections][0]', '[sections]['+(sections_count - 1)+']');

                    $this.attr('name', new_name);
                });
            }else{
                var inputs = cloned.find('[name^="sections[0]"]');
                inputs.each(function(){
                    var $this = $(this),
                        input_name = $this.attr('name'),
                        new_name = input_name.replace('[0]', '['+(sections_count - 1)+']');

                    $this.attr('name', new_name);
                });
            }
        }

        $body.on('click', '.add-section', function(){
            var sections_list = $(this).closest('[class^="col-"]').prev('.sections_list');
            add_section_form(sections_list);
            return false;
        });

        $body.on('click', '.delete-section', function(){
            var section = $(this).closest('.section').remove();
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
