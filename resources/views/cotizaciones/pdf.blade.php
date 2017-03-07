<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $settings->title }}</title>
        <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="screen">
    </head>
    <body>
        <section id="estimate">
            <div class="data">
                <span><b>Servicio:</b> {{ $estimate->service }}</span>
                <br />
                <span><b>Atención:</b> {{ $estimate->client->name }}</span>
            </div><!-- /.data -->

            <div class="description">
                <h3 class="title">Descripción</h3><!-- /.title -->
                <div class="content">{{ $estimate->description }}</div><!-- /.content -->
            </div><!-- /.description -->

            <div class="content">
                <h3 class="title">Alcance</h3><!-- /.title -->
                <div class="service_list">
                    @foreach ($estimate->estimate_services as $service)
                        <div class="service">
                            <h5 class="title">{{ $service->title }}</h5>
                            <div class="content">
                                {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($service->content) !!}
                            </div><!-- /.content -->
                        </div><!-- /.service -->
                    @endforeach
                </div><!-- /.service_list -->
            </div><!-- /.content -->

            <div class="calendar">
                @php
                    $days = $estimate->estimate_services->last()->duration + $estimate->estimate_services->last()->offset;
                @endphp
                <h3 class="title">Calendarización General</h3><!-- /.title -->
                <h4 class="subtitle">Tiempo de realización: <span>{{ $days }} días hábiles</span></h4><!-- /.subtitle -->

                <table class="table">
                    <tr>
                        <td class="sep"></td><!-- /.sep -->
                        <td class="label" colspan="{{ $days - 1 }}">Días hábiles</td><!-- /.label -->
                    </tr>
                    <tr>
                        <td class="sep"></td><!-- /.sep -->
                        @for ($i = 0; $i < $days; $i++)
                            <td class="days_full">
                            </td><!-- /.days_full -->
                        @endfor
                    </tr>
                    <tr>
                        <td class="sep"></td><!-- /.sep -->
                        @php
                            $divider = 2;
                            if($days % 2 == 0) $divider = 2;
                            if($days % 3 == 0) $divider = 3;
                            if($days % 5 == 0) $divider = 5;
                        @endphp
                        @for ($i = 0; $i < $days / $divider; $i++)
                            <td class="days" colspan="{{ $divider }}">
                                {{ ($i+1)*$divider }}
                            </td><!-- /.days -->
                        @endfor
                    </tr>
                    @php
                        $count = 1;
                        $services_count = count($estimate->estimate_services);
                    @endphp
                    @foreach ($estimate->estimate_services as $service)
                        <tr class="service">
                            <td class="label">{{ $service->title }}</td><!-- /.label -->
                            @if($service->offset > 0)
                                <td class="offset" colspan="{{ $service->offset }}">&nbsp;</td><!-- /.offset -->
                            @endif
                            <td class="duration" colspan="{{ $service->duration }}">&nbsp;</td><!-- /.duration -->
                            @if($services_count != $count)
                                <td class="offset" colspan={{ $days - $service->duration }}></td><!-- /.offset -->
                            @endif
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </table><!-- /.table -->
            </div><!-- /.calendar -->

            <div class="investment">
                <h3 class="title">Inversión</h3><!-- /.title -->
                <table class="table">
                    <tr>
                        <td class="title">Total</td><!-- /.title -->
                        <td class="price">
                            <span class="symbol">$</span>
                            <span class="qty">{{ number_format((float) $estimate->total, 2, '.', ',') }}</span>
                            <span class="details">MXN + IVA</span>
                        </td><!-- /.price -->
                    </tr>
                </table><!-- /.table -->

                <h4 class="subtitle">Desglose</h4><!-- /.subtitle -->
                <table class="table">
                    @foreach ($estimate->estimate_services as $service)
                        <tr>
                            <td class="title">{{ $service->title }}</td><!-- /.title -->
                            <td class="price">
                                <span class="symbol detail">$</span>
                                <span class="qty detail">{{ number_format((float) $service->price, 2, '.', ',') }}</span>
                                <span class="details">MXN + IVA</span>
                            </td><!-- /.price -->
                        </tr>
                    @endforeach
                </table><!-- /.table -->

                <h5 class="subtitle_discount">Descuento por pago del 100% anticipado</h5><!-- /.subtitle -->
                <table class="table">
                    <tr>
                        <td class="title">Total</td><!-- /.title -->
                        <td class="price">
                            <span class="symbol">$</span>
                            <span class="qty">{{ number_format((float) $estimate->discount, 2, '.', ',') }}</span>
                            <span class="details">MXN + IVA</span>
                        </td><!-- /.price -->
                    </tr>
                </table><!-- /.table -->
            </div><!-- /.investment -->

            <div class="notes">
                <h3 class="title">Cláusulas de contratación</h3><!-- /.title -->
                <div class="content">
                    @php
                        $all = [];
                    @endphp
                    @foreach ($estimate->estimate_services as $service)
                        @php
                            $notes = explode('- ', $service->notes);
                            $all = array_merge($all, $notes);
                        @endphp
                    @endforeach
                    @php
                        $all = array_filter($all);
                        $all = array_map('trim', $all);
                        $all = array_unique($all);
                    @endphp
                    <ul class="list">
                        @foreach ($all as $note)
                            <li class="item">{{ $note }}</li><!-- /.item -->
                        @endforeach
                    </ul><!-- /.list -->
                </div><!-- /.content -->
            </div><!-- /.notes -->

            <div class="bank_details">
                <h3 class="title">Datos bancarios</h3><!-- /.title -->
                <div class="content">
                    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($settings->bank_details) !!}
                </div><!-- /.content -->
            </div><!-- /.bank_details -->

            <div class="address">
                <h3 class="title">Dirección fiscal</h3><!-- /.title -->
                <div class="content">
                    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($settings->address) !!}
                </div><!-- /.content -->
            </div><!-- /.address -->

            <footer class="footer">
                <div class="signatures">
                    <div class="employee person {{ is_null($estimate->user->picture) ? 'empty' : '' }}">
                        @if(!is_null($estimate->user->picture))
                            <div class="signature">
                                <img src="{{ asset('storage/'.$estimate->user->picture->url) }}" alt="Firma" class="img">
                            </div><!-- /.signature -->
                        @endif
                        <span class="name">{{ $estimate->user->name }}</span>
                    </div><!-- /.employee -->
                    <div class="client person empty">
                        <span class="name">{{ $estimate->client->name }}</span>
                    </div><!-- /.client -->
                </div><!-- /.signatures -->
            </footer><!-- /.footer -->

        </section><!-- /#estimate -->


    </body>
</html>
