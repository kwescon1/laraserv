<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }

    public function participants(): BelongsToMany
    {
        //activity belongs to many participants
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->photo ? '/activities/thumbs/'.$this->photo : '/no_image.jpg',
        );
    }
}
