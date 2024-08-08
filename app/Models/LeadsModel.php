<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsModel extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = ['firstname','lastname','email','notes','mobile','countrycode','referral','termsaccepted'];

}
