<?php

namespace App\Imports;

use App\Models\Dogs;
use Maatwebsite\Excel\Concerns\ToModel;

class DogsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dogs([
            //
        ]);
    }
}
