/*
*	Controller GestStaffController : 
*		- appelé sur la route "/admin/gestionStaff"
*		- injection de la ressource "Staff"
*/
angular.module("DepotVente").controller('GestStaffController',['$scope', 'Staff', '$route',
	function($scope, Staff, $route){

		/*
		*  Récupère toutes les informations des membres du staff
		*/
		$scope.staffs = Staff.query();

		/*
		*  Ajoute un membre au staff
		*/
		$scope.addStaff = function(){
			if($scope.staff.password === $scope.staff.repassword){
				$scope.staff = new Staff({nom: $scope.staff.nom,  
	                            login: $scope.staff.identifiant, 
	                            password: $scope.staff.password, 
	                            permission: $scope.staff.authorisation});
	            $scope.staff.$save(function(data) {
	            						$scope.staffs.push(data);
	            						$route.reload();
	                                },
	                                function(err) {
	                                    $scope.error = err;
	                                });
	        }else{
	        	$scope.error=true;
	        }			
		}

		/*
		*  Supprime un membre du staff
		*  @param staff : le membre à supprimer
		*/
		$scope.deleteStaff = function(staff){
			Staff.delete({id: staff.id});
			for(i in $scope.staffs){
		    	if($scope.staffs[i] === staff){
		        	$scope.staffs.splice(i, 1);
		        	break;
		    	}
			}
		}

		/*
		*  Affiche le formulaire d'édition pour le membre du staff selectionné
		*  @param staff : le membre à éditer  
		*/
		$scope.editStaff = function(staff){
            staff.isediting = true;
        }

        /*
		*  Met à jour un membre du staff
		*  @param staff : le membre à modifier  
		*/
        $scope.updateStaff = function(staff){
        	new Staff({nom: staff.nom,  
	                    login: staff.login, 
	                    password: staff.password, 
	                    permission: staff.permission})
                .$update({id: staff.id},
                function(data){
            		staff.isediting = false;
                },
                function(err) {
                	console.log(err);
                });
        }
}]);