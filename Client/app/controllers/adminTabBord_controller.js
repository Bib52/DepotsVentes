angular.module("DepotVente").controller('TabBordController',['$scope', 'Products', 'Depot', 'Vente',
	function($scope, Products, Depot, Vente){
		
		$scope.products = Products.query(
							function(data) {
                                $scope.nbrProducts=data.length;
                            },
                            function(err) {
                                console.log(err);
                            });
		$scope.depots = Depot.query(
							function(data) {
                                $scope.nbrDepots=data.length;
                            },
                            function(err) {
                                console.log(err);
                            });
        $scope.ventes = Vente.query(
                            function(data) {
                                $scope.nbrVente=data.length;
                            },
                            function(err) {
                                $scope.nbrVente=0;
                                console.log(err);
                            });
}]);