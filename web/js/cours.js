//On indique  à js que l'id premin est celui qu'on doit remplir et on le met dans  la variable premMinElt 
var premMinElt = document.getElementById("premMin");
// Accès aux informations publiques sur le Premier Ministre
ajaxGet("https://www.data.gouv.fr/api/1/organizations/premier-ministre/", function (reponse) {
	//On met la réponse de l'API dans la variable premierMinistre. Il y a tout le texte
    var premierMinistre = JSON.parse(reponse);
    // Ajout de la description et du logo dans la page web
	//On créée la variable js de description dans laquelle on créer un élément HTML de type paragraphe <p>
    var descriptionElt = document.createElement("p");
	//Dans la variable premierMinistre on récupère la balise description. On la rajoute à la variable descriptionElt avec le type textContent
    descriptionElt.textContent = premierMinistre.description;
	//On créée la variable js pour le logo dans laquelle on créer un élément HTML de type image <img>
    var logoElt = document.createElement("img");
	//Dans la variable premierMinistre on récupère la balise logo. On la rajoute à la variable logoElt avec le type src
    logoElt.src = premierMinistre.logo;
	//Dans la div id premMin on place les éléments collectés
    premMinElt.appendChild(descriptionElt);
    premMinElt.appendChild(logoElt);
	
	$(document).ready(function() {
		$.ajax({
			url: "{{ path('bacloocrm_requete1grille') }}",
			 type: 'post',
			 dataType: "json",
			 data: {
			  search: descriptionElt,
			  codeclient: logoElt
			 },
			success: function(data) {
				$('#result').html(data)
			}
		});
	});
});

//Autocomptete code machine
	$(document).ready(function(){
	 $(document).on('keydown', '.codemachine', function() {
	 
	  var id = this.id;
	  var splitid = id.split('_');
	  var index = splitid[1];
		
	  // Initialize jQuery UI autocomplete
	  $( '#'+id ).autocomplete({
	   source: function( request, response ) {
		$('#match').html('<img style="width:55px;height:55px;" src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif" />');
		$.ajax({
		 url: "{{ path('bacloocrm_requete1grille') }}",
		 type: 'post',
		 dataType: "json",
		 data: {
		  search: request.term,request:1,
		  codeclient: {{ id }}
		 },
		 success: function( data ) {
		  response( data );
		  $('#match').text(''); 
		 }
		});
	   },
	   
	   select: function (event, ui) {
		$(this).val(ui.item.label); // display the selected text
		document.getElementById('typemachine_'+index).value = ui.item.value;
		var span = document.getElementById('loyerp1_'+index); span.textContent = ui.item.id;
		var span = document.getElementById('loyerp2_'+index); span.textContent = ui.item.desc;
		var span = document.getElementById('loyerp3_'+index); span.textContent = ui.item.icon;
		var span = document.getElementById('loyerp4_'+index); span.textContent = ui.item.p4;
		var span = document.getElementById('loyermensuel_'+index); span.textContent = ui.item.p5;


		return false;
	   }
	  });
	 });

	 // Add more
	 $('#addmore').click(function(){

	  // Get last id 
	  var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
	  var split_id = lastname_id.split('_');

	  // New index
	  var index = Number(split_id[1]) + 1;

	  // Create row with input elements
	  var html = "<tr class='tr_input'><td><input type='text' class='raisonSociale' id='raisonSociale_"+index+"' placeholder='Enter raisonSociale'></td><td><input type='text' class='cp' id='cp_"+index+"' ></td></tr>";

	  // Append data
	  $('tbody').append(html);	 
	 });
	});
//Fin autocompete code machine	