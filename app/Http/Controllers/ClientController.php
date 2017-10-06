<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Client;
use Excel;

class ClientController extends Controller
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
        $clients = Client::latest()->paginate(15);
        return view('clientes.index', compact('clients'));
    }

    /**
     * Import clients from file.
     *
     * @return \Illuminate\Http\Response
     */
    public function importClients(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            // Getting all results
            $results = $reader->get();

            foreach ($results as $result) {
                Client::create([
                    'name' => (!is_null($result->name)) ? $result->name : 'Sin nombre',
                    'company' => (!is_null($result->company)) ? $result->company : 'Sin empresa',
                    'email' => (!is_null($result->email)) ? $result->email : 'Sin correo',
                    'phone' => (!is_null($result->phone)) ? $result->phone : 'Sin teléfono'
                ]);
            }

            session()->flash('flash_message', 'Se han importado '.$results->count().' clientes');

        });

        return redirect('clientes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());
        session()->flash('flash_message', 'Se ha agregado el cliente: '.$client->name);
        return redirect('clientes');
    }

    /**
     * Get the json of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClientById($id)
    {
        $client = Client::with('estimates')->find($id);
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clientes.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest  $request
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());
        session()->flash('flash_message', 'Se ha actualizado el cliente: '.$client->name);
        return redirect('clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('flash_message', 'Se ha eliminado el cliente');
        return redirect('clientes');
    }
}
