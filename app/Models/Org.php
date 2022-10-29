<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }
}
