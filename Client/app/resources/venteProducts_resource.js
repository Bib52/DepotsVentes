/*
*	factory VenteProducts : retourne la ressource /api/sales/{id}/products/{ref}
*/
angular.module('DepotVente').factory('VenteProducts', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'sales/:id_sale/products/:ref';
    return $resource(uri, {id_sale: '@id_sale',ref: '@ref'}, {
        update: {method: 'put'}
    });
}]);
