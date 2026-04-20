<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['username', 'password', 'fullname', 'position', 'photo_url', 'nip', 'pangkat', 'jabatan', 'is_wali'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false; // tambahkan ini

    protected function casts(): array
    {
        return [
            'is_wali' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function jadwals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Jadwal::class, 'user_id');
    }

    /**
     * Get the user's photo url, properly formatted for Google Drive direct display.
     * Fallback to default avatar or UI Avatars API.
     */
    public function getPhotoUrlAttribute($value)
    {
        // If no photo, use UI Avatars with the user's initials
        if (empty($value)) {
            $name = urlencode($this->fullname ?? 'User');
            return "https://ui-avatars.com/api/?name={$name}&background=3B82F6&color=fff&bold=true&size=128";
        }

        // Return via our proxy route so Google Drive CORS issues are bypassed
        return url('/proxy/photo/' . $this->id);
    }
}
