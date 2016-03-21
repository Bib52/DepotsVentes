angular.module("DepotVente").controller('GestStaffController',['$scope', 'Staff', '$route',
	function($scope, Staff, $route){

		$scope.staffs = Staff.query();

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

		$scope.deleteStaff = function(staff){
			Staff.delete({id: staff.id});
				for(i in $scope.staffs){
			    	if($scope.staffs[i] === staff){
			        	$scope.staffs.splice(i, 1);
			        	break;
			    	}
				}
		}

		$scope.editStaff = function(staff){
            staff.isediting=true;
        }

        $scope.updateStaff = function(staff){
            //faire requete modif staff
            staff.isediting=false;
        }
        

}]);