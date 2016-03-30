/*
*   Controller VenteController : 
*       - appelé sur la route "/vente"
*       - injection des ressources "Vente", "VenteProducts", "ModePaiement", "Config" et "Paiement"
*/
angular.module("DepotVente").controller('VenteController',
		['$scope', 'Vente', 'VenteProducts', 'ModePaiement', 'Config', 'Paiement', '$route',
		function($scope, Vente, VenteProducts, ModePaiement, Config, Paiement, $route){

			/*
			*  Initialisation de variables utilisées dans le contrôleur
			*/
			$scope.objet="";
			$scope.listObjet = {
				objet : []
			};
			$scope.prixtotale=0;
			var hauteur = 0;
			var prix = "";
			$scope.type = "";

			/*
			*  Récupère la commission de la vente
			*/
			Config.get({id:1},function(data){$scope.commission=data.valeur});

			/*
			*  Crée une vente
			*/
			$scope.createVente = function(){
				$scope.vente = new Vente();
        		$scope.vente.$save(function(data) {
                                $scope.venteid = data.id;
                                $scope.playVente = true;
                            },
                            function(err) {
                                $scope.error = err;
                            });
			}

			/*
			*  Ajoute un objet à la vente
			*/
			$scope.addObject = function(){
				new VenteProducts().$update({id_sale: $scope.venteid, ref: $scope.objet.reference},
					                function(data){
					                	if (data.description.length > 10){
					                		data.description = data.description.substr(0,10) + '..';
					                	}
					                    $scope.listObjet.objet.push(data);
										$scope.objet="";
										$scope.prixtotale+=parseFloat(data.prix);
										$scope.error="";
										$scope.prixtotaleAC = $scope.prixtotale + ($scope.commission * $scope.prixtotale / 100);
									},
					                function(err) {
					                    $scope.error = err;
					                });	
			}

			/*
			*  Supprime un objet de la vente 
			*/
			$scope.deleteObject = function(obj){
				VenteProducts.delete({id_sale: $scope.venteid, ref: obj.reference});
				for(i in $scope.listObjet.objet){
			    	if($scope.listObjet.objet[i] === obj){
			        	$scope.listObjet.objet.splice(i, 1);
			        	$scope.prixtotale-=obj.prix;
			        	$scope.prixtotaleAC = $scope.prixtotale + ($scope.commission * $scope.prixtotale / 100);
			        	break;
			    	}
				}
			}

			/*
			*  Affiche le formulaire de validation de la vente 
			*/
			$scope.validVente = function(){
				if($scope.listObjet.objet.length > 0){
					$scope.payment=true;
					$scope.prixtotaleAC = $scope.prixtotale + ($scope.commission * $scope.prixtotale / 100);
					$scope.mdpaiement = ModePaiement.query();
				}
			}

			/*
			*  Calcul la date du jour
			*/
			var calculDate = function(){
				var m = [
					"Janvier", "Février", "Mars",
					"Avril", "Mai", "Juin", "Juillet",
					"Août", "Septembre", "Octobre",
					"Novembre", "Décembre"];
				var d = new Date(Date.now());
				var jour = d.getDate();
				var mois = d.getMonth();
				var annee = d.getFullYear();
				var date = (jour + ' ' + m[mois] + ' ' + annee);
				return date;
			}

			/*
			*  Edite la facture de la vente 
			*/
			$scope.generatePDF = function(){
				new Paiement({prix : $scope.prixtotaleAC, mode_paiements : $scope.modepaiement})
				.$save({id_sale : $scope.venteid},
				function(data) {
					var date = calculDate();
					var facture = new jsPDF();
					facture.setFont('Helvetica-Bold');
					facture.text(20, 20, "Numéro de facture : " + $scope.venteid);
					facture.text(20, 25, "Date : " + date);
					if($scope.vente.nom && $scope.vente.prenom && $scope.vente.adresse && $scope.vente.ville){
						facture.text(120, 40, $scope.vente.nom + " " + $scope.vente.prenom);
						facture.text(120, 45, $scope.vente.adresse);
						facture.text(120, 50, $scope.vente.ville);
					}
					facture.setFontSize(22);
					facture.setFontStyle("bold");
					facture.text(20, 70, "Récapitulatif : ");
					facture.setFontSize(16);
					facture.setFontStyle("normal");
					facture.text(20, 85, "Référence");
					facture.text(60, 85, "Description");
					facture.text(140, 85, "Prix (SC)");
					facture.text(170, 85, "Prix (AC)");
					for(var i = 0; i < $scope.listObjet.objet.length; i++){
						hauteur = 95+5*i;
						var p = parseFloat($scope.listObjet.objet[i].prix);
						prix = (p+(5*p/100)).toFixed(2).toString();
						facture.text(20, hauteur, $scope.listObjet.objet[i].reference.toString());
						facture.text(60, hauteur, $scope.listObjet.objet[i].description);
						facture.text(140, hauteur, $scope.listObjet.objet[i].prix.toFixed(2).toString() + ' €');
						facture.text(170, hauteur, prix + ' €');
					}
					facture.setFontStyle("bold");
					facture.text(100, hauteur+20, "Total (sans commission) : " + $scope.prixtotale + " €");
					facture.text(100, hauteur+25, "Total à payer : " + $scope.prixtotaleAC + " €");
					facture.text(100, hauteur+30, "Réglé par : " + $scope.modepaiement);
					$route.reload();
					facture.save('facture.pdf');
                },
                function(err) {
                    console.log("error");
                });
			}

			/*
			*  Ajoute les coordonnées de l'acheteur à la vente 
			*/
			$scope.addAcheteur = function(){
				new Vente({nom: $scope.vente.nom,
						prenom: $scope.vente.prenom,
						adresse: $scope.vente.adresse,
						ville: $scope.vente.ville,
						email: $scope.vente.email,
						telephone: $scope.vente.telephone}).$update({id: $scope.venteid},
				                function(data){
				                    $scope.generatePDF();
				                },
				                function(err) {
				                    $scope.error = err;
				                });
			}
			
			/*
			*  Annule la vente 
			*/
			$scope.annuleVente = function(){
				Vente.delete({id: $scope.venteid});
				$scope.playVente=false;
				$scope.payment=false;
				$scope.venteid=false;
				$scope.objet="";
				$scope.listObjet = {
					objet : []
				};
				$scope.prixtotale=0;
			}
}]);