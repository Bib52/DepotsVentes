angular.module("DepotVente").controller('DepotController', ['$scope', '$location', 'Depot', 'DepotProducts',
    function ($scope, $location, Depot, DepotProducts) {
        
        $scope.editCoord = false;
        $scope.products = [];
        $scope.totalRembourser=0;
        $scope.temp = "";

        Depot.query(function(data) {
                        $scope.recherche = data;
                        for(i in data){
                            $scope.nbrProduits=0;
                            DepotProducts.query({idDepot: data[i].id},
                                                function(data){
                                                    $scope.produits=data;
                                                    console.log($scope.produits);
                                                    for(i in data){
                                                    //     $scope.produits=data[i];
                                                    //     console.log($scope.produits);
                                                        if(data[i].etat === "Vendu" 
                                                            || data[i].etat === "Perdu"){
                                                            $scope.nbrProduits+=1;
                                                            $scope.totalRembourser+=data[i].prix;
                                                        }
                                                    }   
                                                }); 
                        }
                    });  
        $scope.nomR = null;
        $scope.emailR = null;

        $scope.Search = function () {
            if($scope.emailR != null && $scope.emailR != ""){
                Depot.query(function(data) {
                                for (i in data){
                                    if(data[i].email === $scope.emailR){
                                        $scope.id=data[i].id;
                                        $scope.findDepot();
                                    }
                                }
                            },
                            function(err) {
                                $scope.error = err;
                            });
            }
            else if($scope.nomR != null && $scope.nomR != ""){
                Depot.query(function(data) {
                                for (i in data){
                                    var nomPrenom = data[i].nom + " " + data[i].prenom;
                                    if(nomPrenom === $scope.nomR){
                                        $scope.id=data[i].id;
                                        $scope.findDepot();
                                    }
                                }
                            },
                            function(err) {
                                $scope.error = err;
                            });
            }
        }

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

        var calculDate = function(){
            var m = [
                "Janvier", "Février", "Mars",
                "Avril", "Mai", "Juin", "Juillet",
                "Août", "Septembre", "Octobre",
                "Novembre", "Décembre"];
            var d = new Date(Date.now());
            var jour = d.getDate();
            var mois = d.getMonth();
            var annee = d.getFullYear();
            var date = (jour + ' ' + m[mois] + ' ' + annee);
            return date;
        }

        $scope.recepisseDepot = function(){
            var date = calculDate();
            var facture = new jsPDF();
            facture.setFont('Helvetica-Bold');
            facture.text(20, 20, "Identifiant déposant : " + $scope.depot.id);
            facture.text(20, 28, "Date : " + date);
            facture.text(120, 40, $scope.depot.nom + " " + $scope.depot.prenom);
            facture.text(120, 48, $scope.depot.adresse);
            facture.text(120, 56, $scope.depot.telephone);
            facture.setFontSize(22);
            facture.setFontStyle("bold");
            facture.text(20, 70, "Récapitulatif : ");
            facture.setFontSize(16);
            facture.setFontStyle("normal");
            facture.text(20, 85, "Référence");
            facture.text(60, 85, "Description");
            facture.text(170, 85, "Prix");
            for(i in $scope.products){
                hauteur = 95+5*i;
                if($scope.products[i].reference != undefined){
                    facture.text(20, hauteur, $scope.products[i].reference.toString());
                    facture.text(60, hauteur, $scope.products[i].description);
                    facture.text(170, hauteur, $scope.products[i].prix + ' €');
                }
            }
            facture.save('recepisse.pdf');
        }
}]);
