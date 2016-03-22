angular.module("DepotVente").controller('TabBordController',['$scope', 'Products', 'Depot', 'Vente', 'Paiement', 'Config',
	function($scope, Products, Depot, Vente, Paiement, Config){
		// Nombre de produits
        $scope.products = Products.query(
							function(data) {
                                $scope.nbrProducts = data.length;
                                $scope.nbrEnStock = 0;
                                $scope.nbrCoursVente = 0;
                                $scope.nbrVendu = 0;
                                $scope.nbrRendu = 0;
                                $scope.nbrPerdu = 0;
                                for (i in data){
                                    if(data[i].etat === "En stock"){
                                        $scope.nbrEnStock+=1;
                                    }
                                    if(data[i].etat === "En cours de vente"){
                                        $scope.nbrCoursVente+=1;
                                    }
                                    if(data[i].etat === "Vendu"){
                                        $scope.nbrVendu+=1;
                                    }
                                    if(data[i].etat === "Rendu"){
                                        $scope.nbrRendu+=1;
                                    }
                                    if(data[i].etat === "Perdu"){
                                        $scope.nbrPerdu+=1;
                                    }
                                    //Graphique pie : nombre produits en fonction de son etat
                                    $scope.labelspie=["En stock","En cours de vente","Vendu","Rendu","Perdu"];
                                    $scope.datapie=[$scope.nbrEnStock,$scope.nbrCoursVente,
                                                    $scope.nbrVendu,$scope.nbrRendu,$scope.nbrPerdu];
                                }
                            },
                            function(err) {
                                $scope.nbrProducts=0;
                                console.log(err);
                            });
		
        // Nombre de depot
        $scope.depots = Depot.query(
							function(data) {
                                $scope.nbrDepots=data.length;
                            },
                            function(err) {
                                $scope.nbrDepots=0;
                                console.log(err);
                            });
        
        // Nombre de vente
        $scope.ventes = Vente.query(
                            function(data) {
                                $scope.nbrVenteFini = 0;
                                $scope.nbrVenteEnCours = 0;
                                for (i in data){
                                    if(data[i].etat === 'Finie'){
                                        $scope.nbrVenteFini+=1;
                                    }
                                    if(data[i].etat === 'En cours'){
                                        $scope.nbrVenteEnCours+=1;  
                                    }
                                }
                            },
                            function(err) {
                                $scope.nbrVenteFini=0;
                                $scope.nbrVenteEnCours = 0;
                                console.log(err);
                            });

        //Total des vente avec commission
        //Total des vente sans commission
        //valeur commission en %
        $scope.ventes = Vente.query(
                    function(data) {
                        $scope.totalAC=0;
                        $scope.totalSC=0;
                        $scope.commission=0;
                        for (i in data){
                            if(data[i].etat === 'Finie'){
                                Paiement.get({id_sale : data[i].id},function(data){
                                    $scope.totalAC+=data.prix;
                                    Config.get({id:1}, function(data){
                                        $scope.commission = data.valeur;
                                        $scope.totalSC = (100 * $scope.totalAC) / (100 + $scope.commission);
                                    });
                                });
                            }
                        }
                    },
                    function(err) {
                        $scope.totalAC=0;
                        $scope.totalSC=0;
                        $scope.commission=0;
                        console.log(err);
                    });

        //Graphique line
        $scope.labelsline = ["January", "February", "March", "April", "May", "June", "July"];
        $scope.seriesline = ['Series A', 'Series B'];
        $scope.dataline = [
            [65, 59, 80, 81, 56, 55, 40],
            [28, 48, 40, 19, 86, 27, 90]
        ];
}]);