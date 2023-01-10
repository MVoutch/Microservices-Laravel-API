<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTitle($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 */
class Role extends Model
{
    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
