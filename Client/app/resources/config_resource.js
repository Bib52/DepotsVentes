angular.module('DepotVente').factory('Config', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'configurations/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);