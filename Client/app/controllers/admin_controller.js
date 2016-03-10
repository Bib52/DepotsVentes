angular.module("DepotVente").controller('AdminController',['$scope', 'Products', 'Depot',
		function($scope, Products, Depot){
		
		$scope.products = Products.query(
							function(data) {
                                $scope.nbrProducts=data.length;
								console.log($scope.nbrProducts);
                            },
                            function(err) {
                                console.log(err);
                            });
		$scope.depots = Depot.query(
							function(data) {
                                $scope.nbrDepots=data.length;
								console.log($scope.nbrDepots);
                            },
                            function(err) {
                                console.log(err);
                            });
}]);