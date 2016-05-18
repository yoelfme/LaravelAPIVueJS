<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note', 'category_id'
    ];

    protected $visible = ['id', 'note', 'category_id'];

    protected function category()
    {
        return $this->belongsTo(App\Category::class);
    }
}
