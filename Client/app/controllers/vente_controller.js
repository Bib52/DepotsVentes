angular.module("DepotVente").controller('VenteController',
		['$scope', 'Vente', 'VenteProducts', 'ModePaiement', 'Config', 'Paiement',
		function($scope, Vente, VenteProducts, ModePaiement, Config, Paiement){

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
                                $scope.playVente = true;
                            },
                            function(err) {
                                $scope.error = err;
                            });
			}

			$scope.addObject = function(){
				new VenteProducts().$update({id_sale: $scope.venteid, ref: $scope.objet.reference},
					                function(data){
					                	if (data.description.length > 15){
					                		data.description = data.description.substr(0,15) + '..';
					                	}else{
					                		data.description = data.description;
					                	}
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
					Config.get({id:1},function(data){
						$scope.prixtotaleAC = $scope.prixtotale + (data.valeur * $scope.prixtotale / 100);
					});
					$scope.mdpaiement = ModePaiement.query();
				}
			}

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

			$scope.generatePDF = function(){
				new Paiement({prix : $scope.prixtotaleAC, mode_paiements : $scope.modepaiement})
				.$save({id_sale : $scope.venteid},
				function(data) {
					var date = calculDate();
					var facture = new jsPDF();
					facture.setFont('Helvetica-Bold');
					facture.text(20, 20, "Numéro de facture : " + $scope.venteid);
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
						if ($scope.listObjet.objet[i].description.length > 30){
							facture.text(60, hauteur, $scope.listObjet.objet[i].description.substr(0,30)+"...");
						}else{
							facture.text(60, hauteur, $scope.listObjet.objet[i].description);
						}
						facture.text(140, hauteur, $scope.listObjet.objet[i].prix.toFixed(2).toString() + ' €');
						facture.text(170, hauteur, prix + ' €');
					}
					facture.setFontStyle("bold");
					facture.text(100, hauteur+20, "Total (sans commission) : " + $scope.prixtotale + " €");
					facture.text(100, hauteur+25, "Total à payer : " + $scope.prixtotaleAC + " €");
					facture.text(100, hauteur+30, "Réglé par : " + $scope.modepaiement);
					facture.save('facture.pdf');
                },
                function(err) {
                    console.log("error");
                });
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