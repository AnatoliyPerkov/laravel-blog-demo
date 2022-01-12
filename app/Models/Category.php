<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;


/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 */
class Category extends Model
{
    use NodeTrait; use HasFactory;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];


    public function posts(){
        return $this->hasMany(Post::class);
    }
}
