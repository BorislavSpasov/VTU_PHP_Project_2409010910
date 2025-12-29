<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    // ✅ Add fillable properties for mass assignment
    protected $fillable = [
        'name',
        'breed',
        'age',
        'gender',
        'description',
        'image_url',
        'is_adopted',
    ];
    
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

}
