<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use App\Picture;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = [
            'admin' => 'Administrador',
            'employee' => 'Empleado'
        ];
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($request->hasFile('signature')){
            $url = $request->file('signature')->store('public/signatures');
            $picture = Picture::create([
                'original_name' => $request->file('signature')->getClientOriginalName(),
                'url' => str_replace('public/', '', $url)
            ]);
            $request->merge(['picture_id' => $picture->id]);
        }
        $request->merge(['password' => bcrypt($request->input('password'))]);
        $user = User::create($request->all());
        session()->flash('flash_message', 'Se ha agregado el usuario: '.$user->username);
        return redirect('usuarios');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = [
            'admin' => 'Administrador',
            'employee' => 'Empleado'
        ];
        return view('usuarios.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests|UpdateUserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($request->hasFile('signature')){
            $url = $request->file('signature')->store('public/signatures');
            $picture = Picture::create([
                'original_name' => $request->file('signature')->getClientOriginalName(),
                'url' => str_replace('public/', '', $url)
            ]);
            $request->merge(['picture_id' => $picture->id]);
        }
        if($request->input('password') == ''){
            $user->update($request->except(['password']));
        }else{
            $request->merge(['password' => bcrypt($request->input('password'))]);
            $user->update($request->all());
        }
        session()->flash('flash_message', 'Se ha actualizado el usuario: '.$user->username);
        return redirect('usuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('flash_message', 'Se ha eliminado el usuario');
        return redirect('usuarios');
    }
}
