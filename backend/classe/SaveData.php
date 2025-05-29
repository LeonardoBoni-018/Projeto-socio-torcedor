<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db/index.php';
require_once 'Torcedor.php';

class SaveData
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function save($torcedor)
    {
        $dados = $torcedor->getDados();

        $stmt = $this->conn->prepare(
            "INSERT INTO usuarios (nome, idade, cpf, cidade, email, telefone, criado_em, tipo_assinatura) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sissssss",
            $dados['nome'],
            $dados['idade'],
            $dados['cpf'],
            $dados['cidade'],
            $dados['email'],
            $dados['telefone'],
            $dados['criado_em'],
            $dados['tipo_assinatura']
        );

        header('Content-Type: application/json');
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Dados salvos com sucesso!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao salvar os dados: " . $stmt->error
            ]);
        }

        $stmt->close();
    }

    public function updateTorcedor($torcedor)
    {
        $dados = $torcedor->getDados();

        // Verifica se o ID foi informado
        if (!isset($dados['id'])) {
            echo json_encode(["success" => false, "message" => "ID do torcedor não informado!"]);
            exit;
        }

        $stmt = $this->conn->prepare(
            "UPDATE usuarios SET nome=?, idade=?, cpf=?, cidade=?, email=?, telefone=?, criado_em=?, tipo_assinatura=? WHERE id=?"
        );
        $stmt->bind_param(
            "sissssssi",
            $dados['nome'],
            $dados['idade'],
            $dados['cpf'],
            $dados['cidade'],
            $dados['email'],
            $dados['telefone'],
            $dados['criado_em'],
            $dados['tipo_assinatura'],
            $dados['id']
        );

        header('Content-Type: application/json');
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Dados atualizados com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar os dados: " . $stmt->error]);
        }

        $stmt->close();
    }

    public function deleteTorcedor($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);

        header('Content-Type: application/json');
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Dados deletados com sucesso!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao deletar os dados: " . $stmt->error
            ]);
        }

        $stmt->close();
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM usuarios";
        $result = $this->conn->query($sql);

        $torcedores = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $torcedores[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "data" => $torcedores
        ]);
    }
}
