<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // LIRE tous les étudiants
    case 'GET':
        $stmt = $pdo->query("SELECT *, (note_math + note_phys)/2 AS moyenne FROM etudiant");
        $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($etudiants);
        break;

    // AJOUTER un étudiant
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO etudiant (nom, note_math, note_phys) VALUES (?, ?, ?)");
        if ($stmt->execute([$data['nom'], $data['note_math'], $data['note_phys']])) {
            echo json_encode(["message" => "Insertion réussie"]);
        } else {
            echo json_encode(["message" => "Insertion échouée"]);
        }
        break;

    // MODIFIER un étudiant
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE etudiant SET nom=?, note_math=?, note_phys=? WHERE numEt=?");
        if ($stmt->execute([$data['nom'], $data['note_math'], $data['note_phys'], $data['numEt']])) {
            echo json_encode(["message" => "Modification réussie"]);
        } else {
            echo json_encode(["message" => "Modification échouée"]);
        }
        break;

    // SUPPRIMER un étudiant
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("DELETE FROM etudiant WHERE numEt=?");
        if ($stmt->execute([$data['numEt']])) {
            echo json_encode(["message" => "Suppression réussie"]);
        } else {
            echo json_encode(["message" => "Suppression échouée"]);
        }
        break;
}
?>