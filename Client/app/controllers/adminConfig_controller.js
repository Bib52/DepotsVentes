angular.module("DepotVente").controller('AdminConfigController', ['$scope', 'ModePaiement',
	function($scope, ModePaiement){

		$scope.mdpaiement = ModePaiement.query();
		$scope.commissionA = 0;
		$scope.commissionD = 0;

		$scope.updateCommissionA = function(){
			$scope.iseditingA = false;
			//requete modif commssionA
		}

		$scope.editCommissionA = function(){
			$scope.iseditingA = true;
		}

		$scope.updateCommissionD = function(){
			$scope.iseditingD = false;
			//requete modif commssionD
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