<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products(){
        return $this->hasMany(Product::class, "product_tag_id", "id");
    }

    // public function likes()
    // {
    //     return $this->belongsToMany(User::class, 'product_comment_likes', 'product_comment_id', 'user_id')->withTimestamps();
    // }

    public function likedComments()
    {
        return $this->belongsToMany(ProductComment::class, 'product_comment_likes', 'user_id', 'product_comment_id')->withTimestamps();
    }

    public function notificationMessages(){
        return $this->hasMany(NotificationMessage::class, "referenced_user_id", "id");
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Departments::class, 'user_information', 'user_id', 'department_id')->withTimestamps();
    }

    public function schools()
    {
        return $this->belongsToMany(Schools::class, 'user_information', 'user_id', 'school_id')->withTimestamps();
    }

    public function levels()
    {
        return $this->belongsToMany(Levels::class, 'user_information', 'user_id', 'level_id')->withTimestamps();
    }
}
