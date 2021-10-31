<?php

namespace App\Exports;

use App\Models\People;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeopleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return People::all();
    }
}
