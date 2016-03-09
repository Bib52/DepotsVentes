angular.module("DepotVente").controller('DepotController', ['$scope', '$location', '$http', 'Depot', 'Products',
    function ($scope, $location, $http, Depot, Products) {
        
        $scope.editCoord = false;

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
                                    console.log(data);
                                    $scope.isplay = true;
                                },
                                function(err) {
                                    console.log(err);
                                    console.log("email deja utilisé");
                                });
        };

        $scope.updateCoord = function () {
            console.log("modifie");
            console.log($scope.depot);
            /*new Depot({nom: $scope.depot.nom, 
                        prenom: $scope.depot.prenom, 
                        email: $scope.depot.email, 
                        adresse: $scope.depot.adresse, 
                        telephone: $scope.depot.telephone})
                    .$update({id: $scope.depot.id},
                function(){
                    $scope.editCoord = false;
            });*/
            $scope.editCoord = false;
        }

        $scope.addObject = function(){
            var product = new Products({reference: $scope.objet.reference,
                                    prix: $scope.objet.prix,
                                    description: $scope.objet.description, idDepot: $scope.depot.id});
            product.$save(function(){
                $scope.products = Products.query({idDepot: $scope.depot.id}, function(data) {
                $scope.products.push(product);
                console.log($scope.products);
                $scope.objet="";
                });
            }, function(err){
                $scope.error = err;
                console.log($scope.error);
            });
        }

        $scope.deleteObject = function(obj){
            Products.delete({reference: obj.reference, idDepot: obj.idDepot});
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
            console.log($scope.products);
            objet.isediting=false;
        }

        $scope.findDepot = function(){
            $scope.depot = Depot.get({id: $scope.id}, function() {
                                    console.log($scope.depot);
                                    $scope.isplay = true;
                                },
                                function(err) {
                                    console.log(err);
                                    console.log("Dépôt inexistant");
                                });
            $scope.products = Products.query({idDepot: $scope.id}, function() {
                console.log($scope.products);
            });
            
        }
}]);
