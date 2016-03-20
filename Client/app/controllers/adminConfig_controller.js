angular.module("DepotVente").controller('AdminConfigController', ['$scope', 'ModePaiement',
	function($scope, ModePaiement){

		$scope.mdpaiement = ModePaiement.query();
		$scope.paiement = [];
		$scope.addModePaiement = function(){
			$scope.modePaiement = new ModePaiement({nom : $scope.paiement.nom });
			$scope.modePaiement.$save(function(data) {
                                    console.log(data);
                                });
		}
}]);