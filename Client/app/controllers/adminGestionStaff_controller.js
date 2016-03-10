angular.module("DepotVente").controller('GestStaffController',['$scope',
	function($scope){

		$scope.staffs = [];
		$scope.addStaff = function()
		{
			console.log('ok staff ajouté');
			console.log($scope.staff);
			console.log($scope.staff.authorisation);
			$scope.staffs.push($scope.staff);
			$scope.staff="";
		}
}]);