<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Loja extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email'];

    public static function rules($id = null)
    {
        return [
            'nome' => ['required', 'string', 'max:40', 'min:3'],
            'email' => ['required', 'email', Rule::unique('lojas')->ignore($id),]
        ];
    }

    public static function message()
    {
        return [
            'nome.required' => 'O Nome da Loja é obrigatório!',
            'nome.string' => 'O Nome da Loja deve ser do tipo texto!',
            'nome.max' => 'O Nome da Loja deve ter no máximo 40 caracteres!',
            'nome.min' => 'O Nome da Loja deve ter no mínimo 3 caracteres!',
            'email.required' => 'O E-mail é obrigatório',
            'email.email' => 'O E-mail deve ser no formato de e-mail',
            'email.unique' => 'E-mail já cadastrado!',
        ];
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
