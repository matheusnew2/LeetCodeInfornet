<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Servico extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'servico';
    protected $fillable = ['nome','situacao'];

    public function enderecosServico()
    {
        return $this->belongsToMany(Prestador::class,'prestador_servico','id_servico','id_prestador');
    }
}
