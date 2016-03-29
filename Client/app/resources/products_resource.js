/*
*	factory Products : retourne la ressource /api/products/{ref}
*/
angular.module('DepotVente').factory('Products', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'products/:reference';
    return $resource(uri, {reference: '@reference'});
}]);
