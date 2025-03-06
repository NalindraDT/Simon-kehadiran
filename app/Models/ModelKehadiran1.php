<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelKehadiran1 extends Model
{
    protected $table = 'v_kehadiran_mahasiswa'; // Gunakan VIEW
    protected $primaryKey = 'id_kehadiran'; // Pastikan id_kehadiran memang ada di VIEW
    protected $returnType = 'array'; // Mengembalikan data sebagai array
    protected $useAutoIncrement = false; // Karena VIEW tidak mendukung AutoIncrement
}

