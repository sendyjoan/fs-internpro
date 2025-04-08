<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    public function creating($model)
    {
        if (Auth::check()) {
            $model->created_by = Auth::id();
        }
    }

    public function updating($model)
    {
        if (Auth::check()) {
            $model->updated_by = Auth::id();
        }
    }

    public function deleting($model)
    {
        if (Auth::check()) {
            $model->deleted_by = Auth::id();
            $model->save(); // penting untuk soft delete
        }
    }
}
