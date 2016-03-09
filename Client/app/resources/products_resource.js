angular.module('DepotVente').factory('Products', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'depots/:idDepot/products/:reference';
    return $resource(uri, {idDepot: '@idDepot',ref: '@reference'}, {
        update: {method: 'put'}
    });
}]);