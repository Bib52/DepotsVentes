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

			$scope.generatePDF = function(){
				console.log('generer pdf');
				// var pdf = new JSPF('p','pt','a4');
				// pdf.save('test.pdf');
			}

			$scope.annuleVente = function(){
				console.log('annuler vente');
			}
}]);