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

		$scope.alert = "";

		$scope.updateCommissionA = function(){
			new Config({valeur: $scope.commissionA})
							.$update({id : 1},
							function(data){
								$scope.iseditingA = false;
								$scope.alert = "La modification de la commission sur acheteur a bien été enregistré.";
							});
		}

		$scope.editCommissionA = function(){
			$scope.alert = "";
			$scope.iseditingA = true;
		}

		$scope.updateCommissionD = function(){
			new Config({valeur: $scope.commissionD})
							.$update({id : 2},
							function(data){
								$scope.iseditingD = false;
								$scope.alert = "La modification de la commission sur déposant a bien été enregistré.";
							});
		}

		$scope.editCommissionD = function(){
			$scope.alert = "";
			$scope.iseditingD = true;
		}

		$scope.addModePaiement = function(){
			$scope.modePaiement = new ModePaiement({nom: $scope.paiement.nom});
			$scope.modePaiement.$save(function(data) {
                                    $scope.mdpaiement.push(data);
                                    $scope.paiement = "";
                   					$scope.viewadd = false;
                   					$scope.alert = "Le mode de paiement : "+ data.nom +" a bien été ajouté.";
                                });
		}

		$scope.viewAdd = function(){
			$scope.alert = "";
			$scope.viewadd = true;
		}

		$scope.upModePaiement = function(md){
			new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
								if (data.etat === 0){
                   					$scope.alert = "Le mode de paiement : "+ data.nom +" a été désactivé.";
                   				}else{
                   					$scope.alert = "Le mode de paiement : "+ data.nom +" a été activé.";
                   				}
							});
		}

		$scope.deleteModePaiement = function(md){
			if(confirm("Voulez-vous supprimer le mode de paiement : "+md.nom)){
				ModePaiement.delete({id: md.id});
				$scope.alert = "Le mode de paiement : "+ md.nom +" a été supprimé.";
				for(i in $scope.mdpaiement){
			    	if($scope.mdpaiement[i] === md){
			        	$scope.mdpaiement.splice(i, 1);
			        	break;
			    	}
				}
			}else{
				$scope.alert = "";
			}
		}
		
		$scope.editModePaiement = function(md){
			$scope.alert = "";
            md.isediting = true;
        }

        $scope.updateModePaiement = function(md){
        	new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
				                md.isediting = false;
				                $scope.alert = "La Modification du mode de paiement a bien été enregistré.";
							});
        }
}]);