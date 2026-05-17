<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new Item([
            'cat_id'=>$row['cat_id'],
            'subcat_id'=>$row['subcat_id'],
            'item_name'=>$row['item_name'],
            'slug'=> Str::slug($row['item_name'] . ' ' , '-').'-'.Str::random(5),
            'price'=>$row['price'],
            'item_description'=>$row['item_description'],
            'preparation_time'=>$row['prepration_time'],
            'tax'=>$row['tax'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}


