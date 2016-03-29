window.urlAPI = "http://localhost/DepotsVentes/Server/api/";
var app = angular.module("DepotVente", ['ngResource', 'ngRoute', 'ngSanitize', 'ngMessages', 'chart.js']);

/*
*	config : utilisation de $routeProvider pour le système de routing avec angularJS
*/
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/', {template: "", controller: "firstController"});
    $routeProvider.when('/depot/new', {templateUrl: "app/templates/newdepot.html", controller: "DepotController"});
    $routeProvider.when('/depot/gestion', {templateUrl: "app/templates/gestionDepot.html", controller: "DepotController"});
    $routeProvider.when('/solderDepot', {templateUrl: "app/templates/solderDepot.html", controller: "DepotController"});
    $routeProvider.when('/vente', {templateUrl: "app/templates/vente.html", controller: "VenteController"});
    $routeProvider.when('/admin/config', {templateUrl: "app/templates/adminConfig.html", controller: "AdminConfigController"});
    $routeProvider.when('/admin/tableauBord', {templateUrl: "app/templates/adminTableauBord.html", controller: "TabBordController"});
    $routeProvider.when('/admin/gestionStaff', {templateUrl: "app/templates/adminGestionStaff.html", controller: "GestStaffController"});
}]);

/*
*	controller firstController : est appelé sur la route "/" et elle permet une redirection vers la route "/vente"
*/
app.controller('firstController', ['$location', function($location){
	$location.path('/vente');
}]);