<?php
require ('./classes/Autoload.php');
spl_autoload_register('Autoload::classesAutoloader');

$chat1 = new Chat("José", 5, "vert", "mâle", "siamois");

$chat2 = new Chat("Jean-Yves-Marcel", 3, "turquoise", "mâle", "moche");

$chat3 = new Chat("Esmeralda", 12, "fushia", "femelle", "chartreux");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA - MINOU A ADOPTER</title>
  </head>
  <body>
    <h1>Voici les chatons trop mignons désireux de se faire adopter :</h1>
    <?php $chat1 -> getInfos(); ?><br>
    <?php $chat2 -> getInfos(); ?><br>
    <?php $chat3 -> getInfos(); ?>
  </body>
</html>
