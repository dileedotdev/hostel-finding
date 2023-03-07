<?php

declare(strict_types=1);

namespace App\Models;

use Dinhdjj\Visit\Traits\Visitor;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto {
        getProfilePhotoUrlAttribute as _getProfilePhotoUrlAttribute;
    }
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Visitor;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function hostels(): HasMany
    {
        return $this->hasMany(Hostel::class, 'owner_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'owner_id');
    }

    public function hostelVotes(): HasManyThrough
    {
        return $this->hasManyThrough(Vote::class, Hostel::class, 'owner_id');
    }

    public function subscribedHostels(): BelongsToMany
    {
        return $this->belongsToMany(Hostel::class)->withTimestamps();
    }

    public function canAccessFilament(): bool
    {
        return $this->hasPermissionTo('view.admin-page');
    }

    public function describe(): array
    {
        return \Cache::remember('user-'.$this->getKey().'-describe', 0, function () {
            $votes = $this->hostelVotes()->get();

            $stars = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
            ];

            $votes->groupBy(fn ($vote) => (int) ceil($vote->score * 5))->each(function ($group, $key) use (&$stars): void {
                $stars[$key] = $group->count();
            });

            $hostelVotesCount = $this->hostelVotes()->count();

            return [
                'hostels_count' => $this->hostels()->count(),
                'hostel_votes_count' => $hostelVotesCount,
                'hostel_votes_score_avg' => $this->hostelVotes()->avg('score') ?? 0,
                'stars' => $stars,
            ];
        });
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if (str_starts_with($this->profile_photo_path ?? '', 'http://') || str_starts_with($this->profile_photo_path ?? '', 'https://')) {
            return $this->profile_photo_path;
        }

        return $this->_getProfilePhotoUrlAttribute();
    }
}
