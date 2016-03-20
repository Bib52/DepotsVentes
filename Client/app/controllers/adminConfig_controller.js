angular.module("DepotVente").controller('AdminConfigController', ['$scope', 'ModePaiement',
	function($scope, ModePaiement){

		$scope.mdpaiement = ModePaiement.query();

		$scope.addModePaiement = function(){
			$scope.modePaiement = new ModePaiement({nom: $scope.paiement.nom});
			$scope.modePaiement.$save(function(data) {
                                    console.log(data);
                                    $scope.mdpaiement.push(data);
                   					$scope.paiement=""; 
                                });
		}

		$scope.upModePaiement = function(md){
			new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
				                console.log(data);
							});
		}
}]);