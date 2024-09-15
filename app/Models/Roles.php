<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'can_add_activity',
        'can_add_admin',
        'can_update_user_role' ,
        'can_create_activity' ,
        'can_approve_activity' ,
        'can_delete_activity' ,
        'can_delete_admin' ,
        'can_edit_activity' ,
        
    ];

    /**
     * Get the users associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    /**
     * Get the admins associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id', 'id');
    }
}
