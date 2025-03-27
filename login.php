<?php
session_start();
header('Content-Type: application/json');

// Configurações do banco de dados
$host = "mysql.hostinger.com";
$dbname = "u377990636_DataBase";
$username = "u377990636_Admin";
$password = "+c4Nrz@H5";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erro de conexão com o banco de dados"]));
}

// Obtendo os dados do POST
$data = json_decode(file_get_contents("php://input"), true);
$user = $data["username"];
$pass = $data["password"];

// Verifica no banco de dados
$sql = "SELECT * FROM clientes WHERE usuario = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION["usuario"] = $user;
    echo json_encode(["success" => true, "redirect" => "AM.html"]);
} else {
    // Se não encontrou na tabela clientes, verifica na tabela admin
    $sql = "SELECT * FROM admin WHERE usuario = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["admin"] = $user;
        echo json_encode(["success" => true, "redirect" => "admin.html"]);
    } else {
        echo json_encode(["success" => false, "message" => "Usuário ou senha inválidos, tente novamente"]);
    }
}

$stmt->close();
$conn->close();
?>
