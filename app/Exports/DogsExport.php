<?php

namespace App\Exports;

use App\Models\Dogs;
use Maatwebsite\Excel\Concerns\FromCollection;

class DogsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dogs::all();
    }
}
