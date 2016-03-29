/*
*	factory Paiement : retourne la ressource /api/sale/{id}/payments
*/
angular.module('DepotVente').factory('Paiement', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'sales/:id_sale/payments';
    return $resource(uri, {id_sale: '@id_sale'}, {
        update: {method: 'put'}
    });
}]);