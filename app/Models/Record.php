<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'lead_id',
        'description',
        'type',
        'file',
        'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
