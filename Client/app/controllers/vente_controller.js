angular.module("DepotVente").controller('VenteController',['$scope', 'Vente', 'Products',
		function($scope, Vente, Products){
			$scope.vente = new Vente();
			$scope.vente.$save();
			$scope.objet="";
			$scope.listObjet = {
				objet : []
			};
			$scope.prixtotale=0;

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
				$scope.payment=true;
				//prix ac comission de 5%
				$scope.prixtotaleAC=$scope.prixtotale+(5*$scope.prixtotale/100);
				console.log('vente validé');
				console.log($scope.listObjet);
				console.log($scope.listObjet.objet);
			}

			$scope.calculDate = function(){
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
				var date = $scope.calculDate();
				console.log(date);
				var facture = new jsPDF();
				facture.text(20, 20, "Numero de facture : " /*ajout id vente*/);
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
				facture.setFontSize(22);
				facture.text(20, 60, "Recapitulatif : ");
				facture.setFontSize(16);
				/* Parcours de $scope.listObjet */
				facture.save('facture.pdf');
			}

			$scope.annuleVente = function(){
				console.log('annuler vente');
			}
}]);