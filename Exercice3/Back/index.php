<?php
// Paul Goyer
// Connexion à la BDD

// Il faut au préalable créer une base de données nommée exo3_carlist
  try {
    $instance = new PDO("mysql:host=localhost;dbname=exo3_carlist", "root", "");
  } catch (Exception $e) {
    die($e->getMessage());
  }

// On crée la table car.
$sql = "CREATE TABLE car
(
    id INT PRIMARY KEY NOT NULL,
    brand VARCHAR(40),
    model VARCHAR(40),
    year VARCHAR(40),
    colour VARCHAR(255)
)";
$instance->query($sql);

// On ajoute l'auto-incrémentation sur l'id
$sql = "ALTER TABLE car MODIFY COLUMN id INT auto_increment";
$instance->query($sql);

// On récupère les données envoyées par le formulaire en front
$credentials = array(
  "brand" => $_POST['brand'],
  "model" => $_POST['model'],
  "year" => $_POST['year'],
  "colour" => $_POST['colour'],
);

// On prépare la requête d'insertion
$add = $instance->prepare("INSERT INTO car (brand, model, year, colour) VALUES (:brand, :model, :year, :colour)");

// On exécute la requête
$add->execute(array(
  'brand' => $credentials['brand'],
  'model' => $credentials['model'],
  'year' => $credentials['year'],
  'colour' => $credentials['colour'],
));

// On renvoi la réponse au FRONT en JSON
header('Content-Type: application/json');
// Je formate ma réponse en JSON
echo json_encode(array("success" => true));
