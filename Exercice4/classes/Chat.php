<?php

// Création d'une nouvelle classe Chat
class Chat
{
  public $prenom;
  public $age;
  public $couleur;
  public $sexe;
  public $race;


  function __construct($prenom, $age, $couleur, $sexe, $race)
  {
    // On vérifie que chaque paramètre est bien valide
    if (is_string($prenom) && strlen($prenom) > 3 && strlen($prenom) < 20)
    {
      $this -> prenom = $prenom;
    }
    else
    {
      echo "Le prénom doit comporter entre 3 et 20 caractères";
      // On arrete le script si la condition n'est pas respectée
      die();
    }

    if (is_int($age)) {
      $this -> age = $age;
    }
    else
    {
      echo "L'âge doit être un nombre entier";
      die();
    }

    if (is_string($couleur) && strlen($couleur) > 3 && strlen($couleur) < 10)
    {
      $this -> couleur = $couleur;
    }
    else
    {
      echo "La couleur doit comporter entre 3 et 10 caractères";
      die();
    }

    if (is_string($sexe) && ($sexe === "mâle" || $sexe === "femelle"))
    {
      $this -> sexe = $sexe;
    }
    else
    {
      echo "Le sexe doit être soit mâle soit femelle";
      die();
    }

    if (is_string($race) && strlen($race) > 3 && strlen($race) < 20)
    {
      $this -> race = $race;
    }
    else
    {
      echo "La race doit comporter entre 3 et 20 caractères";
      die();
    }
  }

  // Méthode pour afficher les informations du chat instancié
  public function getInfos() {
    echo "<table>
            <tr>
              <th>Prénom</th>
              <th>Age</th>
              <th>Couleur</th>
              <th>Sexe</th>
              <th>Race</th>
            </tr>
            <tr>
              <td>".$this->prenom."</td>
              <td>".$this->age."</td>
              <td>".$this->couleur."</td>
              <td>".$this->sexe."</td>
              <td>".$this->race."</td>
            </tr>
          </table>";
  }
}
