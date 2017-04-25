<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cotización</title>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,700" rel="stylesheet">
        <style>
            body{
                background-color: #f8f8f8;
                font-family: 'Lato', Helvetica, Arial, sans-serif;
            }
            .email{
                background-color: #fff;
                color: #34495e;
                font-size: 1.1rem;
            }
            .message{
                line-height: 1.5em;
            }
            .message p{
                line-height: 1.5em;
                margin-bottom: .5rem;
                margin-top: 0;
            }
            .signature{
                padding-top: 2rem;
                color: #222222;
            }
            .signature .logo{
                margin-bottom: 1rem;
            }
            .signature .name{
                font-weight: bold;
            }
            .signature .name span:first-child{
                font-family: 'Helvetica', Arial, sans-serif;
                font-size: 18px;
            }
            .signature .name .sep{
                margin: 0 .5rem;
                font-size: 11px;
            }
            .signature .name small{
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: 16px;
            }
            .signature .contact .list{
                list-style: none;
                padding-left: 0;
            }
            .signature .contact .list .item{
                font-size: 13px;
                margin-bottom: .7rem;
                margin-left: 0;
            }
            .signature .contact .list .item .title{
                color: #666666;
                position: relative;
            }
            .signature .contact .list .item .title::before{
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                background: #000000;
                height: 1px;
                width: 6px;
            }
            .footer .backlink{
                color: #1155cc;
                font-size: 13px;
            }
            .footer .backlink .link{
                color: inherit;
            }
        </style>
    </head>
    <body>
        <section class="email">
            <div class="message">
                {!! nl2br($request->input('message')) !!}
            </div>
            <!-- /.message -->

            <div class="signature">
                <img src="https://docs.google.com/uc?export=download&id=0B6xxO42VR_x3T1h3eUp3U0l2Wlk&revid=0B6xxO42VR_x3Wlh0SXdNbzA0TlVyS2xBc0Z6UHhvYStsT0NrPQ" alt="Endor" class="logo">

                <div class="name">
                    <span>{{ \Auth::user()->name }}</span>
                    {{-- <span class="sep"> | </span> --}}
                    {{-- <small>{{ Auth::user()->job_title }}</small> --}}
                </div>
                <!-- /.name -->

                <div class="contact">
                    <ul class="list">
                        <li class="item">
                            <div class="title">MID</div>
                            <!-- /.title -->
                            <div class="phone">T (999) 406-01-47</div>
                            <!-- /.phone -->
                            <div class="address">C.49 X 26 y 28a piso 4 Ofi. 401 Plaza Solare, 97116, Mérida, Yucatán.</div>
                            <!-- /.address -->
                        </li>
                        <!-- /.item -->
                        <li class="item">
                            <div class="title">CDMX</div>
                            <!-- /.title -->
                            <div class="phone">T (55) 41-64-88-60</div>
                            <!-- /.phone -->
                            <div class="address">Prol. Paseo de la Reforma 1015, Piso 3, Santa Fe, Contadero, 01219, CDMX.</div>
                            <!-- /.address -->
                        </li>
                        <!-- /.item -->
                    </ul>
                    <!-- /.list -->
                </div>
                <!-- /.contact -->

                <footer class="footer">
                    <div>
                        <img src="https://docs.google.com/uc?export=download&id=0B6xxO42VR_x3TUw0b012X3ZMOG8&revid=0B6xxO42VR_x3YkZRZUVaMVlZS1p4c25zM05hOUZpa2RzblhJPQ" alt="Grupo Endor" width="420" height="174" class="CToWUd a6T" tabindex="0">
                    </div>
                    <div>
                        <img src="https://docs.google.com/uc?export=download&id=0B6xxO42VR_x3N3ZLNlNOVnRBUlU&revid=0B6xxO42VR_x3emg3UVNZKzdQM0gxeWlyOGhiLzZ2L1dzRnR3PQ" alt="Branding" class="branding">
                    </div>
                    <div class="backlink">¡Visítanos! <a href="https://grupoendor.com" class="link">grupoendor.com</a></div>
                    <!-- /.backlink -->
                </footer>
                <!-- /.footer -->
            </div>

        </section>
        <!-- /.email -->
    </body>
</html>
