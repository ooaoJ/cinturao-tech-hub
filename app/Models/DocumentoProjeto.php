<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoProjeto extends Model
{
    protected $table = 'documentos_projeto';

    protected $fillable = [
        'projeto_id',
        'tipo',
        'arquivo',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
