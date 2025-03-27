<?php

namespace App\Imports;

use Exception;
use App\Models\Major;
use App\Models\SchoolMembershipSummary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MajorImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::BeginTransaction();
        try {
            // get summary 
            $summary = SchoolMembershipSummary::where('school_id', Auth::user()->school_id)->with('membership')->first();
            if ($summary->majors_used >= $summary->membership->max_majors) {
                DB::rollBack();
                Log::info('Maximal Majors Knocked');
                return null;
            }else{
                // dd($major);
                $summary->majors_used += 1;
                $summary->save();
                DB::commit();
            }
        }catch (Exception $e){
            DB::rollBack();
            Log::error('Error Import :'.$e->getMessage());
            return null;
        }
        return new Major([
            'name' => $row['name'],
            'code' => Major::codeGenerator(),
            'school_id' => Auth::user()->school_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
