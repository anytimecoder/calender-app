<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'avatar',
        'title',
        'linkedin_url',
        'company_id',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'person_events')->withPivot('is_attending');
    }

    public function company(): ?BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
