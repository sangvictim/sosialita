<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $table = 'socials';

    protected $fillable = ['user_id', 'provider_name', 'provider_id'];


    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
