angular.module("DepotVente").controller('connexionController',['$scope','$location','Connexion', '$rootScope', 
	function($scope, $location, Connexion, $rootScope){

		$rootScope.connect = false;
		
		$scope.Connect = function(){
			new Connexion({login : $scope.ident, password : $scope.pass})
				.$save(function(data) {
							$rootScope.nom = data.nom;
							$rootScope.connect = true;
							$scope.err = "";
                        	$location.path("/vente");
                       },
                        function(err) {
                            $scope.err = "Erreur Identifiant et/ou Mot de passe !";
                            $scope.infos = "";
                      });
		}

		$scope.Deconnect = function(){
			$rootScope.connect = false;
			$rootScope.nom = "";
			$scope.infos = "Vous êtes déconnecté !";
		}

}]);