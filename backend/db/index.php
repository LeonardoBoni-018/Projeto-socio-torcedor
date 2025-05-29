<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'test';

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// $sql = "CREATE TABLE IF NOT EXISTS usuarios (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     nome VARCHAR(100),
//     idade INT,
//     cpf VARCHAR(14),
//     cidade VARCHAR(100),
//     email VARCHAR(100),
//     telefone VARCHAR(20),
//     criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
//     tipo_assinatura ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze'
// )";

// if ($conn->query($sql) === TRUE) {
//     echo "Tabela 'usuarios' criada com sucesso!";
// } else {
//     die("Erro ao criar tabela: " . $conn->error);
// }
