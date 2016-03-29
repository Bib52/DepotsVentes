/*
*	factory Depot : retourne la ressource /api/depots/{id}
*/
angular.module('DepotVente').factory('Depot', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'depots/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);