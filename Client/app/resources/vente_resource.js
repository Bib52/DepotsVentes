angular.module('DepotVente').factory('Vente', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'sells/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);