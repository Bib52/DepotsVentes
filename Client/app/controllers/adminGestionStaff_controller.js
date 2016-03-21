angular.module("DepotVente").controller('GestStaffController',['$scope', 'Staff',
	function($scope, Staff){

		$scope.staffs = Staff.query();

		$scope.addStaff = function()
		{
			console.log('ok staff ajouté');
			console.log($scope.staff);
			console.log($scope.staff.authorisation);
			$scope.staffs.push($scope.staff);
			$scope.staff="";
		}
}]);