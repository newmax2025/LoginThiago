<?php
session_start();
header('Content-Type: application/json');

// Configuração do banco de dados
$host = "mysql.hostinger.com";
$dbname = "u377990636_DataBase";
$username = "u377990636_Admin";
$password = "+c4Nrz@H5";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erro ao conectar ao banco de dados."]));
}

// Recebendo os dados do POST
$data = json_decode(file_get_contents("php://input"), true);
$user = $data["username"];
$pass = $data["password"];

// Validação básica
if (empty($user) || empty($pass)) {
    die(json_encode(["success" => false, "message" => "Preencha todos os campos!"]));
}

// Busca o usuário no banco de dados
$sql = "SELECT senha FROM clientes WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verifica a senha com password_verify
    if (password_verify($pass, $row["senha"])) {
        $_SESSION["usuario"] = $user;
        echo json_encode(["success" => true, "redirect" => "AM.html"]);
    } else {
        echo json_encode(["success" => false, "message" => "Usuário ou senha inválidos"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Usuário ou senha inválidos"]);
}

$stmt->close();
$conn->close();
?>
