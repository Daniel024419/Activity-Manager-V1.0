<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity_id',
        'user_id',
        'status',
        'remark',
        'manual_updated_at',
        'createdBy',
    ];

    /**
     * Get the activity that owns the update.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * Get the user who made the update.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
}
