<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class PartnerController extends Controller
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            Log::info('Start Process Index Partner Controller');
            $partners = $this->partnerService->getAllPartner();
            dd($partners);
            Log::info('End Process Index Partner Controller');
            return view('modules.partner.index');
        }catch(Exception $e){
            Log::error('Error in Index Partner Controller: '.$e->getMessage());
            Alert::class('error', 'Error in Index Partner Controller: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            Log::info('Start Process Create Partner Controller');

            Log::info('End Process Create Partner Controller');
            return view('modules.partner.create');
        }catch(Exception $e){
            Log::error('Error in Create Partner Controller: '.$e->getMessage());
            Alert::class('error', 'Error in Create Partner Controller: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        try{
            Log::info('Start Process Show Partner Controller');

            Log::info('End Process Show Partner Controller');
            return view('modules.partner.show');
        }catch(Exception $e){
            Log::error('Error in Show Partner Controller: '.$e->getMessage());
            Alert::class('error', 'Error in Show Partner Controller: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        try{
            Log::info('Start Process Edit Partner Controller');

            Log::info('End Process Edit Partner Controller');
            return view('modules.partner.edit');
        }catch(Exception $e){
            Log::error('Error in Edit Partner Controller: '.$e->getMessage());
            Alert::class('error', 'Error in Edit Partner Controller: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        dd('destroy');
    }
}
