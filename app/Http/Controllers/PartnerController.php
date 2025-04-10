<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Services\SchoolService;
use App\Services\PartnerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PartnerController extends Controller
{
    protected $partnerService;
    protected $schoolService;

    public function __construct(PartnerService $partnerService, SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
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
            Log::info('End Process Index Partner Controller');
            return view('modules.partner.index', compact('partners'));
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
            Log::info('Start Process Show Create Partner Form Controller');
            $schools = [];
            if (Auth::user()->hasRole('Super Administrator')) {
                $schools = $this->schoolService->getAllSchools();
            }
            Log::info('End Process Show Create Partner Controller');
            return view('modules.partner.create', compact('schools'));
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
        try{
            Log::debug('Start Process Store Partner Controller');
            $data = $request->all();
            $data['school_id'] = Auth::user()->hasRole('Super Administrator') ? $data['school'] : Auth::user()->school_id;
            $partner = $this->partnerService->createPartner($data);
            if (!$partner) {
                Log::warning('Failed to create partner', ['data' => $data]);
                Alert::toast('Failed to create partner', 'error');
                return back();
            }
            Log::info('End Process Store Partner Controller');
            Alert::toast('Partner created successfully', 'success');
            return redirect()->route('partners.index');
        }catch(Exception $e){
            Log::error('Error in Store Partner Controller: '.$e->getMessage());
            Alert::class('error', 'Error in Store Partner Controller: '.$e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        try{
            Log::info('Start Process Show Partner Controller');
            $partner = $this->partnerService->getPartnerById($partner->id);
            if (!$partner) {
                Log::warning('Failed to fetch partner details', ['partner_id' => $partner->id]);
                Alert::toast('Failed to fetch partner details', 'error');
                return back();
            }
            Log::info('End Process Show Partner Controller');
            return view('modules.partner.show', compact('partner'));
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
        try{
            Log::debug('Start Process Destroy Partner Controller');
            $db_partner = $this->partnerService->deletePartner($partner->id);
            if (!$db_partner) {
                // dd($partner);
                Log::warning('Failed to delete partner', ['partner_id' => $partner->id]);
                Alert::toast('Failed to delete partner', 'error');
                return back();
            }
            Log::info('End Process Destroy Partner Controller');
            Alert::toast('Partner deleted successfully', 'success');
            return redirect()->route('partners.index');
        }catch (Exception $e){
            Log::error('Error in Destroy Partner Controller: '.$e->getMessage());
            Alert::toast('Error in Destroy Partner Controller: '.$e->getMessage(), 'error');
            return back();
        }
    }
}
