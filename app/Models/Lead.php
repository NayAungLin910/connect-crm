<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'value',
        'source_id',
        'progress',
        'moderator_id',
        'admin_id',
        'close_date',
        'contact_id',
        'product_id',
        'quantity',
        'amount',
        'business_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function record()
    {
        return $this->hasMany(Record::class);
    }
}
