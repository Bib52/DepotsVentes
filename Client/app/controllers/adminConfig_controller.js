angular.module("DepotVente").controller('AdminConfigController', ['$scope', 'ModePaiement', 'Config',
	function($scope, ModePaiement, Config){

		//Recuperer les modes de paiements
		$scope.mdpaiement = ModePaiement.query();

		//Recuperer commission sur acheteur
		Config.get({id:1},function(data){
							$scope.commissionA = data.valeur;
						},
                        function(err) {
                            $scope.commissionA = 0;
                        });

		//Recuperer commission sur déposant
		Config.get({id:2},function(data){
							$scope.commissionD = data.valeur;
						},
	                    function(err) {
							$scope.commissionD = 0;
	                    });

		$scope.updateCommissionA = function(){
			new Config({valeur: $scope.commissionA})
							.$update({id : 1},
							function(data){
								$scope.iseditingA = false;
							});
		}

		$scope.editCommissionA = function(){
			$scope.iseditingA = true;
		}

		$scope.updateCommissionD = function(){
			new Config({valeur: $scope.commissionD})
							.$update({id : 2},
							function(data){
								$scope.iseditingD = false;
							});
		}

		$scope.editCommissionD = function(){
			$scope.iseditingD = true;
		}

		$scope.addModePaiement = function(){
			$scope.modePaiement = new ModePaiement({nom: $scope.paiement.nom});
			$scope.modePaiement.$save(function(data) {
                                    $scope.mdpaiement.push(data);
                                    $scope.paiement = "";
                   					$scope.viewadd = false;
                                });
		}

		$scope.viewAdd = function(){
			$scope.viewadd = true;
		}

		$scope.upModePaiement = function(md){
			new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
				                console.log(data);
							});
		}

		$scope.deleteModePaiement = function(md){
			ModePaiement.delete({id: md.id});
				for(i in $scope.mdpaiement){
			    	if($scope.mdpaiement[i] === md){
			        	$scope.mdpaiement.splice(i, 1);
			        	break;
			    	}
				}
		}
		
		$scope.editModePaiement = function(md){
            md.isediting = true;
        }

        $scope.updateModePaiement = function(md){
        	new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
				                md.isediting = false;
							});
        }
}]);