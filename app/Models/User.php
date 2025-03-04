<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'date_of_birth',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public static function validationRules(){
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users, email',
            'phone' => 'required|string|regex:/^[0-9\-\(\)\/\+\s]*$/|min:11',
            'date_of_birth' => 'required|date|bofore:today',
        ];
    }

    public function getAgeAttribure(){
        return $this->date_of_birth ? Carbon::parse($this->date_od_birth)->age : null;
    }
}
