<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'headline',
        'description',
        'image',
        'languages',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'languages' => 'array',
        ];
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'senderable');
    }

    public function creditCard()
    {
        return $this->hasMany(CreditCard::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function social()
    {
        return $this->morphOne(Social::class, 'sociable');
    }

    public function courses()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function lessons()
    {
        return $this->hasMany(DoneLesson::class);
    }
}
