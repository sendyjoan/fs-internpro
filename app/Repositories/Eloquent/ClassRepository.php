<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\SchoolMembershipSummaryService;
use App\Repositories\Contracts\ClassRepositoryInterface;

class ClassRepository implements ClassRepositoryInterface
{
    protected $class;
    protected $schoolMember;

    public function __construct(Kelas $class, SchoolMembershipSummaryService $schoolMember)
    {
        $this->class = $class;
        $this->schoolMember = $schoolMember;
    }

    public function getAll(){
        try{
            Log::info('Fetching all classes from repository');
            if (Auth::user()->hasRole('Super Administrator')) {
                $classes = $this->class->with('major', 'school')->get();
            } else {
                $classes = $this->class->with('major')->where('school_id', Auth::user()->school_id)->get();
            }
            Log::info('Fetched all classes successfully');
            return $classes;
        }catch (Exception $e) {
            Log::error('Error fetching classes: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function findById($id){
        try{
            Log::info('Fetching class with ID '. $id, ['class_id' => $id]);
            if (Auth::user()->hasRole('Super Administrator')) {
                $class = $this->class->with('major', 'school')->findOrFail($id);
            } else {
                $class = $this->class->with('major')->where('school_id', Auth::user()->school_id)->findOrFail($id);
            }
            Log::info('Fetched class successfully');
            return $class;
        }catch(Exception $e){
            Log::error('Error fetching detail class: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function findByCode($code){
        try{
            Log::info('Fetching class with code ' . $code);
            if (Auth::user()->hasRole('Super Administrator')) {
                $class = $this->class->with('major', 'schools')->where('code', $code)->firstOrFail();
            } else {
                $class = $this->class->with('major')->where('school_id', Auth::user()->school_id)->where('code', $code)->firstOrFail();
            }
            Log::info('Fetched class successfully');
            return $class;
        }catch(Exception $e){
            Log::error('Error fetching class: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function create(array $data){
        // dd($data);
        try{
            DB::BeginTransaction();
            Log::info('Creating class in repository with data', $data);
            $data['code'] = $this->class->codeGenerator();
            if (Auth::user()->hasRole('Super Administrator')) {
                $class = $this->class->create($data);
                try{
                    $this->schoolMember->increaseClass($class->school_id);
                }catch(Exception $e){
                    DB::rollBack();
                    Log::error('Error creating class: ' . $e->getMessage());
                    return $e->getMessage();
                }
            } else {
                $class = $this->class->create(array_merge($data, ['school_id' => Auth::user()->school_id]));
                try{
                    $this->schoolMember->increaseClass($class->school_id);
                }catch(Exception $e){
                    DB::rollBack();
                    Log::error('Error creating class: ' . $e->getMessage());
                    return $e->getMessage();
                }
            }
            Log::info('Class created successfully', $class->toArray());
            DB::commit();
            return $class;
        }catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating class: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function update($id, array $data){
        try{
            Log::info('Updating class in repository with data', $data);
            $class = self::findById($id);
            if (is_object($class)) {
                if (Auth::user()->hasRole('Super Administrator')) {
                    $class->update($data);
                } else {
                    $class->update(array_merge($data, ['school_id' => Auth::user()->school_id]));
                }
                Log::info('Class updated successfully', $class->toArray());
                return $class;
            } else {
                Log::error('Class not found or invalid: ' . $class);
                return 'Class not found or invalid';
            }
            Log::info('Class updated successfully', $class->toArray());
            return $class;
        }catch (Exception $e) {
            Log::error('Error updating class: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function delete($id){
        try{
            DB::beginTransaction();
            Log::info('Deleting class with ID ' . $id);
            $class = self::findById($id);
            // dd($class);
            if (is_object($class)) {
                $class->deleted_by = Auth::user()->id;
                $class->save();
                $class->delete();
                $this->schoolMember->decreaseClass($class->school_id);
                Log::info('Class deleted successfully', $class->toArray());
                DB::commit();
                return $class;
            } else {
                Log::error('Class not found or invalid: ' . $class);
                return 'Class not found or invalid';
            }
        }catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting class: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}