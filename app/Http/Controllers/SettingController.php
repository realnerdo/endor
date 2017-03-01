<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Setting;
use App\Picture;

class SettingController extends Controller
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
        $setting = Setting::first();
        return view('ajustes.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SettingRequest  $request
     * @param  Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        if($request->hasFile('logo')){
            $url = $request->file('logo')->store('public/logo');
            $setting->logo->update([
                'original_name' => $request->file('logo')->getClientOriginalName(),
                'url' => str_replace('public/', '', $url)
            ]);
        }
        $setting->update($request->all());
        session()->flash('flash_message', 'Se han actualizado los ajustes');
        return redirect('ajustes');
    }
}
