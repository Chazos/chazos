<?php

namespace App\Imports;

use App\Models\Cats;
use Maatwebsite\Excel\Concerns\ToModel;

class CatsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cats([
            //
        ]);
    }
}
