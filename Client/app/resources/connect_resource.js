angular.module('DepotVente').factory('Connexion', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'staffs/signin';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);