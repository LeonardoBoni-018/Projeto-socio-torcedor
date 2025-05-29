<?php
class Torcedor
{
    private $id, $nome, $idade, $cpf, $cidade, $email, $telefone, $criado_em, $tipo_assinatura;

    public function __construct($id, $nome, $idade, $cpf, $cidade, $email, $telefone, $criado_em, $tipo_assinatura)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->idade = $idade;
        $this->cpf = $cpf;
        $this->cidade = $cidade;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->criado_em = $criado_em ?? date('Y-m-d H:i:s');
        $this->tipo_assinatura = $tipo_assinatura;
    }

    public function getDados()
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'idade' => $this->idade,
            'cpf' => $this->cpf,
            'cidade' => $this->cidade,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'criado_em' => $this->criado_em,
            'tipo_assinatura' => $this->tipo_assinatura
        ];
    }
}
