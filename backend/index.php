<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'db/index.php';
require_once 'classe/Torcedor.php';
require_once 'classe/SaveData.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$dao = new SaveData($conn);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $torcedor = new Torcedor(
            null,
            $input['nome'],
            $input['idade'],
            $input['cpf'],
            $input['cidade'],
            $input['email'],
            $input['telefone'],
            $input['criado_em'] ?? null,
            $input['tipo_assinatura'] ?? null
        );
        $dao->save($torcedor);
        break;

    case 'GET':
        $id = isset($input['id']) ? $input['id'] : null;
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $torcedor = $result->fetch_assoc();
            echo json_encode([
                "success" => true,
                "data" => $torcedor
            ]);
        } else {
            $result = $conn->query("SELECT * FROM usuarios");
            $torcedores = [];
            while ($row = $result->fetch_assoc()) {
                $torcedores[] = $row;
            }
            echo json_encode([
                "success" => true,
                "data" => $torcedores
            ]);
        }
        break;

    case 'PUT':
        $torcedor = new Torcedor(
            $input['id'],
            $input['nome'],
            $input['idade'],
            $input['cpf'],
            $input['cidade'],
            $input['email'],
            $input['telefone'],
            $input['criado_em'] ?? null,
            $input['tipo_assinatura'] ?? null
        );
        $dao->updateTorcedor($torcedor);
        break;

    case 'DELETE':
        $dao->deleteTorcedor($input['id']);
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Método não suportado"
        ]);
        break;
}

$conn->close();
