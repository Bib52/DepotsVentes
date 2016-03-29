angular.module("DepotVente").controller('AdminConfigController', ['$scope', 'ModePaiement', 'Config',
	function($scope, ModePaiement, Config){

		//Recuperer les modes de paiements
		$scope.mdpaiement = ModePaiement.query();

		//Recuperer commission
		Config.get({id:1},function(data){
							$scope.commission = data.valeur;
						},
                        function(err) {
                            $scope.commission = 0;
                        });

		$scope.alert = "";

		/*
		*  Met à jour la commission
		*/
		$scope.updateCommission = function(){
			new Config({valeur: $scope.commission})
							.$update({id : 1},
							function(data){
								$scope.Comisediting = false;
								$scope.alert = "La modification de la commission a bien été enregistré.";
							});
		}

		/*
		*  Affiche le formulaire de mise à jour de la commission 
		*/
		$scope.editCommission = function(){
			$scope.alert = "";
			$scope.Comisediting = true;
		}

		/*
		*  Ajoute un nouveau mode de paiement 
		*/
		$scope.addModePaiement = function(){
			$scope.modePaiement = new ModePaiement({nom: $scope.paiement.nom});
			$scope.modePaiement.$save(function(data) {
                                    $scope.mdpaiement.push(data);
                                    $scope.paiement = "";
                   					$scope.viewadd = false;
                   					$scope.alert = "Le mode de paiement : "+ data.nom +" a bien été ajouté.";
                                });
		}

		/*
		*  Affiche le formulaire d'ajout de mode de paiement
		*/
		$scope.viewAdd = function(){
			$scope.alert = "";
			$scope.viewadd = true;
		}

		/*
		*  Met à jour le mode de paiement sélectionné
		*  @param md : mode de paiement à mettre à jour 
		*/
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

		/*
		*  Supprime le mode de paiement sélectionné
		*  @param md : mode de paiement à supprimer
		*/
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
		
		/*
		* Affiche le formulaire d'édition du mode de paiement sélectionné
		* @param md : mode de paiement selectionné 
		*/
		$scope.editModePaiement = function(md){
			$scope.alert = "";
            md.isediting = true;
        }

        /*
		*  Met à jour le mode de paiement sélectionné 
		*  @param md : mode de paiement à mettre à jour
		*/
        $scope.updateModePaiement = function(md){
        	new ModePaiement({nom: md.nom, etat: md.etat})
							.$update({id : md.id},
							function(data){
				                md.isediting = false;
				                $scope.alert = "La Modification du mode de paiement a bien été enregistré.";
							});
        }
}]);