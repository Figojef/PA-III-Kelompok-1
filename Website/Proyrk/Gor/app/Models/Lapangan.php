<?php

namespace App\Models; // Kalau ada Models
// namespace App; // Kalau tidak ada Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangans'; // Nama tabel di database
}
