<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        dd('destroy');
    }
}
