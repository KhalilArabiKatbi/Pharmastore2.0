<?php

namespace App\Models;

use App\Models\MedicineCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'sciname' ,
            'tradename' ,
            'manufacturer',
            'qtn',
            'expiry',
            'price',
            'medicine_category_id'
    ];
    
    public function medicinecategory(){

        return $this->belongsTo(MedicineCategory::class);

    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
