<?php
require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

// Identifiants fixes (vous pouvez changer)
$username = "admin";
$password = "123";

if ($data['username'] === $username && $data['password'] === $password) {
    echo json_encode(["success" => true, "message" => "Connexion réussie"]);
} else {
    echo json_encode(["success" => false, "message" => "Nom ou mot de passe sont incorrects"]);
}
?>