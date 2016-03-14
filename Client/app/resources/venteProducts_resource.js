angular.module('DepotVente').factory('VenteProducts', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'sales/{idSale}/products/{reference}';
    return $resource(uri, {idSale: '@idSale',reference: '@reference'}, {
        update: {method: 'put'}
    });
}]);
