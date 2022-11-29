<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'title',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function texts()
    {
        return $this->hasMany(Text::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function dragdrops()
    {
        return $this->hasMany(Dragdrop::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
