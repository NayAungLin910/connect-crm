<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'org_id',
    ];

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function email()
    {
        return $this->hasMany(Email::class);
    }

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function lead()
    {
        return $this->hasMany(Lead::class);
    }
}
