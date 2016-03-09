angular.module('DepotVente').factory('Produit', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'products/:reference';
    return $resource(uri, {reference: '@reference'});
}]);