<?php

namespace App\Exports;

use App\Models\Major;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MajorExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        try{
            if(Auth::user()->hasRole('Super Administrator')) {
                Log::info('Fetching all majors from export for user Super Administrator');
                return Major::select('code', 'name')->get();
            }else{
                Log::info('Fetching all majors from export');
                return Major::select('code', 'name')->where('school_id', Auth::user()->school_id)->get();
            }
        }catch(\Exception $e){
            Log::error('Error fetching majors: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Code", "Name"];
    }
}
