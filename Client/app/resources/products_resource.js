angular.module('DepotVente').factory('Products', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'depots/:idDepot/products';
    return $resource(uri, {idDepot: '@idDepot',reference: '@reference'}, {
        update: {method: 'put'}
    });
}]);