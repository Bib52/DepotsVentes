angular.module("DepotVente").controller('TabBordController',['$scope', 'Products', 'Depot', 'Vente',
	function($scope, Products, Depot, Vente){
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
                                data.length;
                            },
                            function(err) {
                                $scope.nbrVenteFini=0;
                                $scope.nbrVenteEnCours = 0;
                                console.log(err);
                            });

        //Total des vente sans commission
        $scope.totalSC=0;

        //Total des vente avec commission
        $scope.totalAC=0;

        //Graphique line
        $scope.labelsline = ["January", "February", "March", "April", "May", "June", "July"];
        $scope.seriesline = ['Series A', 'Series B'];
        $scope.dataline = [
            [65, 59, 80, 81, 56, 55, 40],
            [28, 48, 40, 19, 86, 27, 90]
        ];
}]);