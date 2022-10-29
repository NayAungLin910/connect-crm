<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "lead_id",
        "moderator_id",
        "admin_id",
        "description",
        "type", 
        "file",
        "file_name",
        "start_date",
        "end_date",
        "done",
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }
}
