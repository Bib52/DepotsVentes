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
						$scope.prixtotale+=$scope.produit.prix;
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
}]);