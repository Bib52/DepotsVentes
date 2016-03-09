angular.module("DepotVente").controller('connexionController',['$scope','$location',
	function($scope, $location){

		$scope.user="";

		$scope.Connect = function(){
			// $scope.deconnect=true;
			console.log("connexion");
			console.log($scope.user);
			$scope.ident = $scope.user.ident;
			$scope.pass = $scope.user.pass;
			$location.path("/vente")
		}

}]);