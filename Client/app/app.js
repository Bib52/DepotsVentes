window.urlAPI = "http://localhost/DepotsVentes/Server/api/";
var app = angular.module("DepotVente", ['ngResource', 'ngRoute', 'ngSanitize', 'ngMessages', 'chart.js']);

app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/', {templateUrl: "app/templates/connexion.html", controller: "connexionController"});
    $routeProvider.when('/depot/new', {templateUrl: "app/templates/newdepot.html", controller: "DepotController"});
    $routeProvider.when('/depot/gestion', {templateUrl: "app/templates/gestionDepot.html", controller: "DepotController"});
    $routeProvider.when('/vente', {templateUrl: "app/templates/vente.html", controller: "VenteController"});
    $routeProvider.when('/admin/config', {templateUrl: "app/templates/adminConfig.html", controller: "AdminConfigController"});
    $routeProvider.when('/admin/tableauBord', {templateUrl: "app/templates/adminTableauBord.html", controller: "TabBordController"});
    $routeProvider.when('/admin/gestionStaff', {templateUrl: "app/templates/adminGestionStaff.html", controller: "GestStaffController"});
}]);