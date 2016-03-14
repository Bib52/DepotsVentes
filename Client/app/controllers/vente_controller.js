angular.module("DepotVente").controller('VenteController',['$scope', 'Vente', 'Products', '$route',
		function($scope, Vente, Products, $route){
			// $scope.vente = new Vente();
			// $scope.vente.$save();
			$scope.objet="";
			$scope.listObjet = {
				objet : []
			};
			$scope.prixtotale=0;
			var hauteur = 0;
			var prix = "";
			$scope.type = "";

			$scope.createVente = function(){
				$scope.vente = new Vente();
            	$scope.vente.$save(function(data) {
                                    console.log(data);
                                    $scope.playVente=true;
                                },
                                function(err) {
                                    $scope.error = err;
                                    console.log(err);
                                });
			}
			$scope.addObject = function(){	
				$scope.produit = Products.get({reference: $scope.objet.reference}, 
					function() {
                		console.log("ajout objet");
                		console.log($scope.produit);
                		$scope.listObjet.objet.push($scope.produit);
						$scope.objet="";
						$scope.prixtotale+=parseFloat($scope.produit.prix);
						$scope.error="";
           			},
           			function(err){
           				console.log(err);
           				$scope.error = err;
           			});	
			}

			$scope.deleteObject = function(obj){
				for(i in $scope.listObjet.objet){
			    	if($scope.listObjet.objet[i] === obj){
			        	$scope.listObjet.objet.splice(i, 1);
			        	$scope.prixtotale-=obj.prix;
			        	break;
			    	}
				}
			}

			$scope.validVente = function(){
				if($scope.listObjet.objet.length > 0){
					$scope.payment=true;
					//prix ac comission de 5%
					$scope.prixtotaleAC=$scope.prixtotale+(5*$scope.prixtotale/100);
					console.log('vente validé');
					console.log($scope.listObjet);
					console.log($scope.listObjet.objet);
				}
			}

			var calculDate = function(){
				var m = [
					"Janvier", "Fevrier", "Mars",
					"Avril", "Mai", "Juin", "Juillet",
					"Aout", "Septembre", "Octobre",
					"Novembre", "Decembre"];
				var d = new Date(Date.now());
				var jour = d.getDate();
				var mois = d.getMonth();
				var annee = d.getFullYear();
				var date = (jour + ' ' + m[mois] + ' ' + annee);
				return date;
			}

			$scope.generatePDF = function(){
				console.log('generer pdf');
				var date = calculDate();
				console.log($scope.listObjet.objet[0]);
				var facture = new jsPDF();
				if($scope.display){
					facture.text(20, 20, "Numero de facture : " /*ajout id vente*/);
				}
				facture.text(20, 30, "Date : " + date);
				if($scope.vente.nom && $scope.vente.prenom){
					facture.text(120, 40, $scope.vente.nom + " " + $scope.vente.prenom);
				}
				else if($scope.vente.prenom){
					facture.text(120, 40, $scope.vente.prenom);
				}
				else if($scope.vente.nom){
					facture.text(120, 40, $scope.vente.nom);
				}
				if($scope.vente.adresse){
					facture.text(120, 48, $scope.vente.adresse);
				}
				if($scope.vente.ville){
					facture.text(120, 56, $scope.vente.ville);
				}
				facture.setFontSize(22);
				facture.text(20, 75, "Recapitulatif : ");
				facture.setFontSize(16);
				facture.text(20, 85, "Reference");
				facture.text(60, 85, "Description");
				facture.text(170, 85, "Prix");

				for(var i = 0; i < $scope.listObjet.objet.length; i++){
					hauteur = 95+10*i;
					var p = parseFloat($scope.listObjet.objet[i].prix);
					prix = (p+(5*p/100)).toFixed(2).toString();
					facture.text(20, hauteur, $scope.listObjet.objet[i].reference);
					facture.text(60, hauteur, $scope.listObjet.objet[i].description);
					facture.text(170, hauteur, prix);
				}
				facture.text(100, 225, "Total a payer : " + $scope.prixtotaleAC + " euros");
				if($scope.vente.paiement === "1"){
					$scope.type = "Liquide";
				}
				if($scope.vente.paiement === "2"){
					$scope.type = "Carte Bancaire";
				}
				if($scope.vente.paiement === "3"){
					$scope.type = "Cheque";
				}
				facture.text(100, 235, "Regle par : " + $scope.type);
				facture.save('facture.pdf');
			}

			$scope.annuleVente = function(){
				console.log('annuler vente');
				$route.reload();
			}
}]);