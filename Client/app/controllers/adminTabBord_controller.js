angular.module("DepotVente").controller('TabBordController',['$scope', 'Products', 'Depot', 'Vente',
	function($scope, Products, Depot, Vente){
		// Nombre de produits
        $scope.products = Products.query(
							function(data) {
                                $scope.nbrProducts=data.length;
                                $scope.nbrEnStock=0;
                                $scope.nbrVendu=0;
                                $scope.nbrPerdu=0;
                                for (i in data){
                                    if(data[i].etat=="En stock"){
                                        $scope.nbrEnStock+=1;
                                    }
                                    if(data[i].etat=="Vendu"){
                                        $scope.nbrVendu+=1;
                                    }
                                    if(data[i].etat=="Perdu"){
                                        $scope.nbrPerdu+=1;
                                    }
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
                                $scope.nbrVente=data.length;
                            },
                            function(err) {
                                $scope.nbrVente=0;
                                console.log(err);
                            });

        //Total des vente sans commission
        $scope.totalSC=0;

        //Total des vente avec commission
        $scope.totalAC=0;

        //Graphique pie : nombre produits
        $scope.labelspie=["En stock","Vendu","Perdu"];
        $scope.datapie=[100,50,10];

        //Graphique line
        $scope.labelsline = ["January", "February", "March", "April", "May", "June", "July"];
        $scope.seriesline = ['Series A', 'Series B'];
        $scope.dataline = [
            [65, 59, 80, 81, 56, 55, 40],
            [28, 48, 40, 19, 86, 27, 90]
        ];
}]);