<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokoRequest;
use App\Models\Toko;
use RealRashid\SweetAlert\Facades\Alert;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toko = Toko::first();

        return view('setting.toko.index', compact('toko'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function update(TokoRequest $request, Toko $toko)
    {
        $toko->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return back();
    }
}
