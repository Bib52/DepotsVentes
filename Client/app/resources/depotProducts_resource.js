/*
*	factory DepotProducts : retourne la ressource /api/depots/{id}/products/{ref}
*/
angular.module('DepotVente').factory('DepotProducts', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'depots/:idDepot/products/:ref';
    return $resource(uri, {idDepot: '@idDepot',ref: '@ref'}, {
        update: {method: 'put'}
    });
}]);