<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RolePermission;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    public function permission(): HasOne
    {
        return $this->hasOne(RolePermission::class);
    }

    protected $fillable = [
        'menu_show',
        'menu_name',
        'level',
        'parent_menu',
        'parent_menu_id',
        'module',
        'base_url',
        'route',
        'active',
        'serial',
        'icon',
    ];
}
