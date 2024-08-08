<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsEncryptionModel extends Model
{
    use HasFactory;

    protected $table = 'leads_encryption';

    protected $fillable = ['lead','firstname','lastname','email','notes','mobile','referral'];

    protected $casts = [
        'firstname' => 'encrypted',
        'lastname' => 'encrypted',
        'email' => 'encrypted',
        'notes' => 'encrypted',
        'mobile' => 'encrypted',
        'referral' => 'encrypted'
    ];
}
