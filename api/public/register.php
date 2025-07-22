<?php

header('Content-Type: application/json');
require_once '../dbconnect.php';

// Récupération des données JSON envoyées
$datas = json_decode(file_get_contents('php://input'),true);
//aucune donnée
if(!isset($datas['nom']) || !isset($datas['prenom']) || !isset($datas['login']) || !isset($datas['password']) || !isset($datas['tel'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Remplissez tous les champs obligatoires *']);
    exit;
}

//On recupère les données
$nom = htmlspecialchars($datas['nom']);
$prenom = htmlspecialchars($datas['prenom']);
$login = htmlspecialchars($datas['login']);
$password = htmlspecialchars($datas['password']);
$tel = htmlspecialchars($datas['tel']);

//Hachage du mot de passe
if(strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'Le mot de passe doit contenir au moins 8 caractères']);
    exit;
}
$password = password_hash(htmlspecialchars($password), PASSWORD_BCRYPT);

//on genere un token
$token = bin2hex(random_bytes(16));

// Insertion dans la base de données
try{
    $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, login, tel, password, token) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $login, $tel, $password, $token]);

    // Récupérer l'id du nouvel utilisateur
    $userId = $pdo->lastInsertId();

    // Créer un frigo automatiquement
    $nom_frigo = "frigo_" . strtolower($prenom . $nom);
    $stmt = $pdo->prepare("INSERT INTO frigos (nom_frigo, user_id) VALUES (?, ?)");
    $stmt->execute([$nom_frigo, $userId]);

    echo json_encode(['success' => true, 'message' => 'Utilisateur inscrit avec succès']);
}catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'inscription : ' . $e->getMessage()]);
    exit;
}
