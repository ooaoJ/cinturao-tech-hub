<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'projetos';

    protected $fillable = [
        'equipe_id',
        'titulo',
        'descricao',
        'problema_resolvido',
        'link_prototipo',
        'link_repositorio',
        'status',
        'aprovado_orientador',
    ];

    protected function casts(): array
    {
        return [
            'aprovado_orientador' => 'boolean',
        ];
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoProjeto::class, 'projeto_id');
    }

    public function testes()
    {
        return $this->hasMany(Teste::class, 'projeto_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'projeto_id');
    }
}
