<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\PartnerRepositoryInterface;
use App\Repositories\Eloquent\SchoolMembershipSummaryRepository;

class PartnerRepository implements PartnerRepositoryInterface
{
    protected $partner;
    protected $schoolMembershipSummary;

    public function __construct(Partner $partner, SchoolMembershipSummaryRepository $schoolMembershipSummary)
    {
        $this->schoolMembershipSummary = $schoolMembershipSummary;
        $this->partner = $partner;
    }

    public function getAll(){
        try{
            Log::debug('Fetching all partners from repository');
            if (Auth::user()->hasRole('Super Administrator')) {
                $partners = $this->partner->with('school')->get();
            } else {
                $partners = $this->partner->with('school')->where('school_id', Auth::user()->school_id)->get();
            }
            Log::debug('Fetched all partners successfully', $partners->toArray());
            return $partners;
        }catch (Exception $e) {
            Log::error('Error fetching partners: ' . $e->getMessage(), ['location' => "Name File : ".__FILE__."Line : ". __LINE__, 'details' => $e->getTrace()]);
            return false;
        }
    }

    public function findById($id){
        try{
            Log::info('Fetching partner with ID '. $id, ['partner_id' => $id]);
            if (Auth::user()->hasRole('Super Administrator')) {
                $partner = $this->partner->with('school')->findOrFail($id);
            } else {
                $partner = $this->partner->where('school_id', Auth::user()->school_id)->findOrFail($id);
            }
            Log::info('Fetched partner successfully', $partner->toArray());
            return $partner;
        }catch(Exception $e){
            Log::error('Error fetching detail partner: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function findByCode($code){
        // 
    }

    public function create(array $data){
        try{
            Log::debug('Creating partner in repository with data', $data);
            if (Auth::user()->hasRole('Super Administrator')) {
                $data['school_id'] = $data['school'];
            } else {
                $data['school_id'] = Auth::user()->school_id;
            }
            $data['code'] = $this->partner->codeGenerator();
            $partner = $this->partner->create($data);
            return $partner;
        }catch (Exception $e){
            Log::error('Error creating partner: ' . $e->getMessage(), ['location' => "Name File : ".__FILE__."Line : ". __LINE__, 'details' => $e->getTrace()]);
            return false;
        }
    }

    public function update($id, array $data){
        try{
            Log::info('Updating class in repository with data', $data);
            $partner = self::findById($id);
            if (is_object($partner)) {
                $data['updated_by'] = Auth::user()->id;
                if (Auth::user()->hasRole('Super Administrator')) {
                    $partner->update($data);
                } else {
                    $partner->update(array_merge($data, ['school_id' => Auth::user()->school_id]));
                }
                Log::info('Class updated successfully', $partner->toArray());
            } else {
                Log::error('Class not found or invalid: ' . $partner);
                return ['success' => false, 'message' => 'Class not found or invalid'];
            }
            Log::info('Class updated successfully', $partner->toArray());
            return ['success' => true, 'message' => 'Class updated successfully'];
        }catch (Exception $e) {
            Log::error('Error updating class: ' . $e->getMessage(), ['location' => "Name File : ".__FILE__."Line : ". __LINE__, 'details' => $e->getTrace()]);
            return ['success' => false, 'message' => 'Error updating class: ' . $e->getMessage()];
        }
    }

    public function delete($id){
        try{
            Log::info('Deleting partner with ID '. $id, ['partner_id' => $id]);
            if (Auth::user()->hasRole('Super Administrator')) {
                $partner = $this->partner->findOrFail($id);
            } else {
                $partner = $this->partner->where('school_id', Auth::user()->school_id)->findOrFail($id);
            }
            $partner->delete();
            Log::info('Partner deleted successfully', ['partner_id' => $id]);
            return true;
        }catch(Exception $e){
            Log::error('Error deleting partner: ' . $e->getMessage());
            return false;
        }
    }
}