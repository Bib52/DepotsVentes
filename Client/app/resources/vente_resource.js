angular.module('DepotVente').factory('Vente', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'sales/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);