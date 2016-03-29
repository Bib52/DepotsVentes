/*
*	factory Staff : retourne la ressource /api/staffs/{id}
*/
angular.module('DepotVente').factory('Staff', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'staffs/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);