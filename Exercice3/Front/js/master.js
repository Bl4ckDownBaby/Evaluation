$(document).ready(function () {

  // Lors de l'envoi des données du formulaire
  $('#add-car').submit(function(e) {
    // On stop le comportement par défaut
    e.preventDefault();

    // On récupère les données et les met dans un tableau
    var datas = $(this).serializeArray();
    var formatDatas = {};
    console.log(datas);

    for(var i=0; i < datas.length; i++) {
      console.log(datas[i]);
      formatDatas[datas[i]['name']] = datas[i]['value'];
    }
    addCar(formatDatas);
  })

  var addCar = function(credentials) {
    // On va créer une nouvelle requête AJAX qui va ajouter une voiture à la BDD
    $.ajax({
      method: 'POST',
      url: '../Back/index.php',
      data: credentials,
      success: function(response) {
        console.log("response", response);
        // Si l'ajout à bien réussi, on déclenche une alert marquant "C'est réussi"
        if(response.success) {
          alert("C'est réussi !");
        }
      }
    })
  }
})
