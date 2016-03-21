angular.module("DepotVente").controller('VenteController',['$scope', 'Vente', 'VenteProducts', '$route', 'ModePaiement',
		function($scope, Vente, VenteProducts, $route, ModePaiement){
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
                                    $scope.venteid = data.id;
                                    $scope.playVente=true;
                                },
                                function(err) {
                                    $scope.error = err;
                                });
			}

			$scope.addObject = function(){
				new VenteProducts().$update({id_sale: $scope.venteid, ref: $scope.objet.reference},
					                function(data){
					                    $scope.listObjet.objet.push(data);
										$scope.objet="";
										$scope.prixtotale+=parseFloat(data.prix);
										$scope.error="";
					                },
					                function(err) {
					                    $scope.error = err;
					                });	
			}

			$scope.deleteObject = function(obj){
				VenteProducts.delete({id_sale: $scope.venteid, ref: obj.reference});
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
					$scope.mdpaiement = ModePaiement.query();
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
				var date = calculDate();
				var facture = new jsPDF();
				facture.setFont('Helvetica-Bold');
				facture.text(20, 20, "Numero de facture : " + $scope.venteid);
				facture.text(20, 25, "Date : " + date);
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
					facture.text(120, 45, $scope.vente.adresse);
				}
				if($scope.vente.ville){
					facture.text(120, 50, $scope.vente.ville);
				}
				facture.setFontSize(22);
				facture.setFontStyle("bold");
				facture.text(20, 70, "Recapitulatif : ");
				facture.setFontSize(16);
				facture.setFontStyle("normal");
				facture.text(20, 85, "Reference");
				facture.text(60, 85, "Description");
				facture.text(170, 85, "Prix");
				for(var i = 0; i < $scope.listObjet.objet.length; i++){
					hauteur = 95+5*i;
					var p = parseFloat($scope.listObjet.objet[i].prix);
					prix = (p+(5*p/100)).toFixed(2).toString();
					facture.text(20, hauteur, $scope.listObjet.objet[i].reference.toString());
					facture.text(60, hauteur, $scope.listObjet.objet[i].description);
					facture.text(170, hauteur, prix);
				}
				facture.setFontStyle("bold");
				facture.text(120, hauteur+20, "Total a payer : " + $scope.prixtotaleAC + " euros");
				if($scope.vente.paiement === "1"){
					$scope.type = "Liquide";
				}
				if($scope.vente.paiement === "2"){
					$scope.type = "Carte Bancaire";
				}
				if($scope.vente.paiement === "3"){
					$scope.type = "Cheque";
				}
				facture.text(120, hauteur+25, "Regle par : " + $scope.type);
				facture.save('facture.pdf');
			}

			$scope.addAcheteur = function(){
				new Vente({nom: $scope.vente.nom,
						prenom: $scope.vente.prenom,
						adresse: $scope.vente.adresse,
						ville: $scope.vente.ville,
						email: $scope.vente.email,
						telephone: $scope.vente.telephone}).$update({id: $scope.venteid},
				                function(data){
				                    console.log(data);
				                },
				                function(err) {
				                    $scope.error = err;
				                });
			}
			$scope.annuleVente = function(){
				Vente.delete({id: $scope.venteid});
				$route.reload();
			}
}]);