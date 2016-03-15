angular.module('DepotVente').factory('Paiement', ['$resource', function ($resource) {
    var uri = window.urlAPI + '/api/sales/:id_sale/payments';
    return $resource(uri, {id_sale: '@id_sale'}, {
        update: {method: 'put'}
    });
}]);