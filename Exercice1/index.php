<?php
// Paul Goyer
// Exercice 1 : "Jointons!"
// Dans un fichier à part, écrire la requête SQL permettant d’afficher un article (id = 10) et son auteur à l’aide d’une jointure.
//  Note : ​N’écrivez que la requête SQL, pas de PHP.

"SELECT articles.id, users.firstname FROM articles INNER JOIN users ON id_user = user.id WHERE id = 10";

 ?>
