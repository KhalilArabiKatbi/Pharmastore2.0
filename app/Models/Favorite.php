<?php

// app/Models/Favorite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['pharmacy_id', 'medicine_id'];

    public function pharmacy()
    {
        return $this->belongsTo(User::class, 'pharmacy_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
