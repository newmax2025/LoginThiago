<?php
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

// Recebendo os dados
$data = json_decode(file_get_contents("php://input"), true);
$user = $data["username"];
$pass = password_hash($data["password"], PASSWORD_DEFAULT); // Senha criptografada

// Validação básica
if (empty($user) || empty($pass)) {
    die(json_encode(["success" => false, "message" => "Preencha todos os campos!"]));
}

// Insere no banco de dados
$sql = "INSERT INTO clientes (usuario, senha) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao cadastrar usuário."]);
}

$stmt->close();
$conn->close();
?>
