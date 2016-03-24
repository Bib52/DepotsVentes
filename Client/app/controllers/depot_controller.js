angular.module("DepotVente").controller('DepotController', ['$scope', '$location', 'Depot', 'DepotProducts',
    function ($scope, $location, Depot, DepotProducts) {
        
        $scope.editCoord = false;
        $scope.products = [];
        $scope.totalRembourser=0;
        $scope.temp = "";

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
                    if (data.description.length > 20){
                        data.description = data.description.substr(0,20) + '..';
                    }
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
            $scope.temp = objet.etat;
        }

        $scope.updObject = function(objet){
            new DepotProducts({prix: objet.prix,
                            description: objet.description,
                            etat: objet.etat})
            .$update({idDepot: objet.id_depot, ref: objet.reference},
            function(data){
                objet.isediting=false;
                if($scope.temp !== "Perdu" && data.etat === "Perdu"){
                    $scope.totalRembourser+=data.prix;
                }
                if(data.etat === "En stock" && $scope.temp === "Perdu"){
                    $scope.totalRembourser-=data.prix;
                }
                if (objet.description.length > 20){
                    objet.description = objet.description.substr(0,20) + '..';
                }
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
            $scope.products = DepotProducts.query({idDepot: $scope.id}, function(data) {
                                            for(i in $scope.products){
                                                if($scope.products[i].etat === "Vendu" 
                                                    || $scope.products[i].etat === "Perdu"){
                                                    $scope.totalRembourser+=$scope.products[i].prix;
                                                }
                                                if ($scope.products[i].description != undefined 
                                                    && $scope.products[i].description.length > 20){
                                                    $scope.products[i].description = $scope.products[i].description.substr(0,20) +'..';
                                                }
                                            }
                                        });
        }

        $scope.deleteDepot = function(){
            if(confirm("Voulez-vous supprimer le dépôt ainsi que ces poduits ?"))
            {
                Depot.delete({id: $scope.depot.id},
                            function() {
                                $scope.isplay = false;
                                $scope.depot = "";
                                $location.path("/depot/new");
                            },
                            function(err) {
                                $scope.error = err;
                            });
            }
        }

        $scope.payer = function(){
            DepotProducts.query({idDepot: $scope.depot.id}, function(data) {
                for(i in data){
                    if(data[i].etat === "Vendu" || data[i].etat === "Perdu"){
                        new DepotProducts({prix: data[i].prix,
                            description: data[i].description,
                            etat: "Payé"})
                            .$update({idDepot: data[i].id_depot, ref: data[i].reference},
                            function(data){
                                $scope.totalRembourser-=data.prix;
                                for(i in $scope.products){
                                    if ($scope.products[i].reference === data.reference){
                                        $scope.products[i].etat = "Payé";
                                    }
                                }
                            });
                    }
                }
            });
        }
}]);
