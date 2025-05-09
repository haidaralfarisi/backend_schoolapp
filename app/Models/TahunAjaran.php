<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ereport()
    {
        return $this->hasMany(Ereport::class,'tahun_ajaran_id');
    }
}
