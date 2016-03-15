angular.module('DepotVente').factory('ModePaiement', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'payments/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);