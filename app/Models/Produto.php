<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Produto extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['nome', 'valor', 'ativo'];

    public static function rules()
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'max:60'],
            'valor' => ['required', 'integer', 'between:10,999999'],
            'ativo' => ['boolean']
        ];
    }

    public static function message()
    {
        return [
            'nome.required' => 'O Nome do Produto é obrigatório!',
            'nome.string' => 'O Nome do Produto deve ser do tipo texto!',
            'nome.max' => 'O Nome da Produto deve ter no máximo 60 caracteres!',
            'nome.min' => 'O Nome da Produto deve ter no mínimo 3 caracteres!',
            'valor.required' => 'O Valor do Produto é obrigatório',
            'valor.integer' => 'O valor do Produto deve ser do tipo Inteiro',
            'valor.between' => 'O valor do produto deve ser entre 10 e 999999',
            'ativo.boolean' => 'Deve ser verdadeiro ou falso'
        ];
    }

    protected function valor(): Attribute
    {
        return Attribute::make(
            get: fn($value) => "R$ " . number_format($value, 2, ',', '.')
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public
    function loja()
    {
        return $this->belongsTo(Loja::class);
    }
}
