<?php
// Paul Goyer
// Exercice 2 : « Le stagiaire  »
//
// Un stagiaire, dont vous êtes responsable, doit récupérer une liste d’utilisateurs depuis une base de données mais également donner la possibilité d’en ajouter à l’aide d’un formulaire.
//
// Le script principal se compose de deux parties :  - La liste des utilisateurs et leurs informations - Le formulaire d’ajout d’un nouvel utilisateur
//
// Le stagiaire débute dans la programmation PHP. Il n’indente et ne commente pas son code. En tant que maître de stage, vous devez l’aider à corriger et faire fonctionner son code. Une bonne indentation du code est également nécessaire


// On modifie "connection.php" en "connect.php" pour correspondre au bon fichier
require_once 'connect.php';

$order = '';

// Ajout d'une parenthèse pour fermer la condition
if(isset($_GET['order']) && isset($_GET['column']))
{
	// Correction des "colum" en "column" ainsi que de "ordre" en "order"
	if($_GET['column'] == 'lastname'){$order = ' ORDER BY lastname';}
	elseif($_GET['column'] == 'firstname'){$order = ' ORDER BY firstname';}
	elseif($_GET['column'] == 'birthdate'){$order = ' ORDER BY birthdate';}
	if($_GET['order'] == 'asc'){$order.= ' ASC';}
	elseif($_GET['order'] == 'desc'){$order.= ' DESC';}
}

// Si $_POST n'est pas vide, On test la validation des champs | On prépare la requête d'ajout | On l'exécute en mettant les valeurs du formulaire "$_POST"
if(!empty($_POST))
{
	foreach($_POST as $key => $value)
	{
		// Suppression d'une parenthèse après (trim($value))
		$post[$key] = strip_tags(trim($value));
	}
	// On fait les tests de validation des champs de formulaire
	// Modification des "$post" par "$_POST"
	if(strlen($_POST['firstname']) < 3)
	{
		$errors[] = 'Le prénom doit comporter au moins 3 caractères';
	}
	if(strlen($_POST['lastname']) < 3)
	{
		$errors[] = 'Le nom doit comporter au moins 3 caractères';
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors[] = 'L\'adresse email est invalide';
	}
	if(empty($_POST['birthdate']))
	{
		$errors[] = 'La date de naissance doit être complétée';
	}
	if(empty($_POST['city']))
	{
		$errors[] = 'La ville ne peut être vide';
	}

	// Si tous les champs sont valides on prépare la requête d'insertion d'utilisateur
	if(!isset($errors))
	{
		$insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES(:gender, :firstname, :lastname, :email, :birthdate, :city)');
		// Modification de $post en $_POST
		$insertUser->bindValue(':gender', $_POST['gender']);
		$insertUser->bindValue(':firstname', $_POST['firstname']);
		$insertUser->bindValue(':lastname', $_POST['lastname']);
		$insertUser->bindValue(':email', $_POST['email']);
		$insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($_POST['birthdate'])));
		$insertUser->bindValue(':city', $_POST['city']);

		if($insertUser->execute())
		{
			$createUser = true;
		}
	}
	else
	{
		$errors[] = 'Erreur SQL';
	}
}

// Requête d'affichage des utilisateurs
$queryUsers = $db->prepare('SELECT * FROM users'.$order);
if($queryUsers->execute())
{
	// Correction "-->" en "->"
	$users = $queryUsers->fetchAll();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Exercice 2</title>
		<meta charset="utf-8">

		<!-- Bootstrap -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>

		<div class="container">

			<h1>Liste des utilisateurs</h1>

			<p>Trier par :
				<a href="index.php?column=firstname&order=asc">Prénom (croissant)</a> |
				<a href="index.php?column=firstname&order=desc">Prénom (décroissant)</a> |
				<a href="index.php?column=lastname&order=asc">Nom (croissant)</a> |
				<a href="index.php?column=lastname&order=desc">Nom (décroissant)</a> |
				<a href="index.php?column=birthdate&order=desc">Âge (croissant)</a> |
				<a href="index.php?column=birthdate&order=asc">Âge (décroissant)</a>
			</p>
			<br>

			<div class="row">

<?php
// Si l'ajout d'utilisateur à réussi
if(isset($createUser) && $createUser == true)
{
	echo '<div class="col-md-6 col-md-offset-3">';
	echo '<div class="alert alert-success">Le nouvel utilisateur a été ajouté avec succès.</div>';
	echo '</div><br>';
}

// Modification "$errors" en "$error"
// Si $error n'est pas vide, on affiche
if(!empty($errors))
{
	echo '<div class="col-md-6 col-md-offset-3">';
	echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>';
	echo '</div><br>';
}
?>
				<div class="col-md-7"> <!-- Tableau des utilisateurs -->
					<table class="table">
						<thead>
							<tr>
								<th>Civilité</th>
								<th>Prénom</th>
								<th>Nom</th>
								<th>Email</th>
								<th>Age</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($users as $user):?>
							<tr>
								<td><?php echo $user['gender'];?></td>
								<td><?php echo $user['firstname'];?></td>
								<td><?php echo $user['lastname'];?></td>
								<td><?php echo $user['email'];?></td>
								<td><?php echo DateTime::createFromFormat('Y-m-d', $user['birthdate'])->diff(new DateTime('now'))->y;?> ans</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div> <!-- fin du tableau des utilisateurs -->

				<div class="col-md-5"> <!-- formulaire d'ajout d'utilisateur -->
					<form method="post" class="form-horizontal well well-sm">
					<fieldset>
					<legend>Ajouter un utilisateur</legend>

						<div class="form-group">
							<label class="col-md-4 control-label" for="gender">Civilité</label>
							<div class="col-md-8">
								<select id="gender" name="gender" class="form-control input-md" required>
									<option value="Mlle">Mademoiselle</option>
									<option value="Mme">Madame</option>
									<option value="M">Monsieur</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="firstname">Prénom</label>
							<div class="col-md-8">
								<input id="firstname" name="firstname" type="text" class="form-control input-md" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="lastname">Nom</label>
							<div class="col-md-8">
								<input id="lastname" name="lastname" type="text" class="form-control input-md" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="email">Email</label>
							<div class="col-md-8">
								<input id="email" name="email" type="email" class="form-control input-md" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="city">Ville</label>
							<div class="col-md-8">
								<input id="city" name="city" type="text" class="form-control input-md" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="birthdate">Date de naissance</label>
							<div class="col-md-8">
								<input id="birthdate" name="birthdate" type="text" placeholder="JJ-MM-AAAA" class="form-control input-md" required>
								<span class="help-block">au format JJ-MM-AAAA</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Envoyer</button>
							</div>
						</div>
					</fieldset>
					</form>
				</div> <!-- fin du formulaire d'ajout d'utilisateur -->

			</div> <!-- End of row -->

		</div> <!-- Enf of container -->
	</body>
</html>
