@extends('layout.base')

@section('title', 'Usuarios')
@section('sectionTitle', 'Usuarios')
@section('add')
    <div class="buttons pr">
        <a href="{{ url('usuarios/nuevo') }}" class="btn btn-blue add"><i class="typcn typcn-plus"></i> Nuevo usuario</a>
    </div>
    <!-- /.buttons -->
@endsection

@section('content')
    @unless ($users->isEmpty())
        {{-- <div class="row">
            {{ Form::open(['url' => '/', 'class' => 'form']) }}
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('name', 'Nombre', ['class' => 'label']) }}
                        {{ Form::input('text', 'name', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('username', 'Usuario', ['class' => 'label']) }}
                        {{ Form::input('text', 'username', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
                <div class="col-4">
                    <div class="form-group">
                        {{ Form::label('email', 'Correo electrónico', ['class' => 'label']) }}
                        {{ Form::input('text', 'email', null, ['class' => 'input']) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col-4 -->
            {{ Form::close() }}
        </div>
        <!-- /.row --> --}}
    @endunless
    <div class="row">
        <div class="col-12">
            @if ($users->isEmpty())
                <div class="empty">
                    <i class="typcn typcn-coffee"></i>
                    <h2 class="title">Aún no hay usuarios</h2>
                    <!-- /.title -->
                    <a href="{{ url('usuarios/nuevo') }}" class="btn btn-blue">Agregar un usuario</a>
                </div>
                <!-- /.empty -->
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Correo electrónico</th>
                            <th>Registro</th>
                            <th>Cotizaciones</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td data-th="Nombre">{{ $user->name }} {!! ($user->role == 'admin') ? '<span class="badge badge-blue">Administrador</span>' : '<span class="badge badge-blue">Vendedor</span>' !!}</td>
                                <td data-th="Usuario">{{ $user->username }}</td>
                                <td data-th="Correo electrónico"><a href="mailto:{{ $user->email }}" class="link">{{ $user->email }}</a></td>
                                <td data-th="Registro">{{ ucfirst(\Date::createFromFormat('Y-m-d H:i:s', $user->created_at)->diffForHumans()) }}</td>
                                <td data-th="Cotizaciones"><a href="{{ url('cotizaciones') }}" class="link">{{ $user->estimates()->count() }}</a></td>
                                <td data-th="Opciones">
                                    <span href="#" class="dropdown">
                                        <i class="typcn typcn-social-flickr"></i>
                                        <ul class="list">
                                            <li class="item">
                                                <a href="{{ url('usuarios/'.$user->id.'/editar') }}" class="link"><i class="typcn typcn-edit"></i> Editar</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                <a href="{{ url('cotizaciones') }}" class="link"><i class="typcn typcn-clipboard"></i> Cotizaciones</a>
                                            </li>
                                            <!-- /.item -->
                                            <li class="item">
                                                {{ Form::open(['url' => url('usuarios', $user->id), 'method' => 'DELETE', 'class' => 'delete-form']) }}
                                                    <button type="submit" class="link"><i class="typcn typcn-delete"></i> Eliminar</button>
                                                {{ Form::close() }}
                                            </li>
                                            <!-- /.item -->
                                        </ul>
                                        <!-- /.list -->
                                    </span><!-- /.dropdown -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- /.table -->
            @endif
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="pagination">
                {{ $users->links() }}
            </div>
            <!-- /.pagination -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endsection
