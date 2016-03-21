angular.module("DepotVente").controller('DepotController', ['$scope', '$location', 'Depot', 'DepotProducts',
    function ($scope, $location, Depot, DepotProducts) {
        
        $scope.editCoord = false;
        $scope.products = [];

        $scope.EditCoord = function () {
            $scope.editCoord = true;
        };

        $scope.createDepot = function () {
            $scope.depot = new Depot({nom: $scope.depot.nom, 
                            prenom: $scope.depot.prenom, 
                            email: $scope.depot.email, 
                            adresse: $scope.depot.adresse, 
                            telephone: $scope.depot.telephone});
            $scope.depot.$save(function(data) {
                                    $scope.isplay = true;
                                },
                                function(err) {
                                    $scope.error = err;
                                });
        };

        $scope.updateCoord = function () {
            new Depot({nom: $scope.depot.nom, 
                        prenom: $scope.depot.prenom, 
                        email: $scope.depot.email, 
                        adresse: $scope.depot.adresse, 
                        telephone: $scope.depot.telephone})
                .$update({id: $scope.depot.id},
                function(data){
                    $scope.editCoord = false;
                },
                function(err) {
                    $scope.error = err;
                });
        }

        $scope.addObject = function(){
            var product = new DepotProducts({reference: $scope.objet.reference,
                                    prix: $scope.objet.prix,
                                    description: $scope.objet.description, 
                                    idDepot: $scope.depot.id});
            product.$save(function(data) {
                    $scope.products.push(data);
                    $scope.objet=""; 
                }, 
                function(err){
                    $scope.error = err;
                });
        }

        $scope.deleteObject = function(obj){
            DepotProducts.delete({ref: obj.reference, idDepot: obj.id_depot});
            for(i in $scope.products){
                if($scope.products[i] === obj){
                    $scope.products.splice(i, 1);
                    break;
                }
            }
        } 

        $scope.editObject = function(objet){
            objet.isediting=true;
        }

        $scope.updObject = function(objet){
            new DepotProducts({prix: objet.prix,
                            description: objet.description,
                            etat: objet.etat})
            .$update({idDepot: objet.id_depot, ref: objet.reference},
            function(data){
                objet.isediting=false;
            },
            function(err) {
                $scope.error = err;
            });
        }

        $scope.findDepot = function(){
            $scope.depot = Depot.get({id: $scope.id}, function() {
                                    $scope.isplay = true;
                                },
                                function(err) {
                                    $scope.error = err;
                                });
            $scope.products = DepotProducts.query({idDepot: $scope.id});
        }

        $scope.deleteDepot = function(){
            if(confirm("Voulez-vous supprimer le dépôt ainsi que ces poduits ?"))
            {
                Depot.delete({id: $scope.id},
                            function() {
                                $location.path("/depot/new")
                            },
                            function(err) {
                                $scope.error = err;
                            });
            }
        }
}]);
