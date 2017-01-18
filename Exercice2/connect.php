<?php

// On change le nom de la table "userlist" en "exo1_userslist" afin qu'elle corresponde à celle présente dans la base de donnée (importée depuis le script)

$db = new PDO('mysql:host=localhost;dbname=exo1_userslist;charset=utf8', 'root', '');
