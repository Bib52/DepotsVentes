<?php

//Recuperer le depot id ------>  OK
$app->get('/api/depots/{id}', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $depot = mysql_query('SELECT * FROM depots WHERE id='.$id);
    $obj = mysql_fetch_object($depot);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    return $response;
});

//Recuperer la vente id ------>  OK
$app->get('/api/sells/{id}', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $vente = mysql_query('SELECT * FROM ventes WHERE id='.$id);
    $obj = mysql_fetch_object($vente);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    return $response;
});

//Creer un depot ------>  OK
$app->post('/api/depots', function ($request, $response) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['nom'])
        && !empty($params['prenom'])
        && !empty($params['email'])
        && !empty($params['adresse'])
        && !empty($params['telephone'])
    ) {
        $connectdb=mysql_connect($host, $userdb, $pass);
        $db=mysql_select_db($dbname);
        $find = mysql_query('SELECT * FROM depots WHERE email="'.$params['email'].'"');
        $obj = mysql_fetch_object($find);
        if(!$obj){
            $sql = "INSERT INTO depots (nom, prenom, email, adresse, telephone)
                    VALUES ('".$params['nom']."','"
                            .$params['prenom']."','"
                            .$params['email']."','"
                            .$params['adresse']."','"
                            .$params['telephone']."')";
            $insert = mysql_query($sql);
            if($insert){
                $response = $response->withStatus(201, 'Product created');
                $response = $response->withHeader('Content-Type', 'application/json');
                $find = mysql_query('SELECT * FROM depots WHERE email="'.$params['email'].'"');
                $depot = mysql_fetch_object($find);
                $response = $response->write(json_encode($depot));
            }
            else{
                echo'error insertion';
            }
        }
        else {
            $response = $response->withStatus(400, 'email already use');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Recuperer tous les produits ------>  OK
$app->get('/api/products', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $produits = mysql_query('SELECT * FROM produits');
    if(mysql_num_rows($produits) !== 0) {
        while ($row = mysql_fetch_assoc($produits)) {
            $response = $response->write(json_encode($row));
        }
    } else {
        $response = $response->withStatus(404, 'Aucun produit enregistre');
    }
    return $response;
});

//Recuperer le produit ref ------>  OK
$app->get('/api/products/{reference}', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $produit = mysql_query('SELECT * FROM produits WHERE reference='.$reference);
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    return $response;
});

//Supprimer le produit ref ------>  OK
$app->delete('/api/products/{reference}', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $produit = mysql_query('SELECT * FROM produits WHERE reference='.$reference);
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        $produit = mysql_query('DELETE FROM produits WHERE reference='.$reference);
        $response = $response->withStatus(200, 'Product deleted');
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    return $response;
});

//Creer une vente
$app->post('/api/sells', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    $collection = (new MongoClient())->depotsventes->sells;
    $result = $collection->insert(['products' => []]);
    $response = $response->withStatus(201, 'Product created');
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->write(json_encode($result));
    return $response;
});

//Permet d ajouter des produits dans un depots ------>  OK
$app->post('/api/depots/{id_depot}/products', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $idDepot = $args['id_depot'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['reference'])
        && !empty($params['prix'])
        && !empty($params['description'])
    ) {    
        $connectdb=mysql_connect($host, $userdb, $pass);
        $db=mysql_select_db($dbname);
        $find = mysql_query('SELECT * FROM depots WHERE id="'.$idDepot.'"');
        $obj = mysql_fetch_object($find);
        if(! empty($obj)){
            $find = mysql_query('SELECT * FROM produits WHERE reference="'.$params['reference'].'"');
            $depot = mysql_fetch_object($find);
            if (empty($depot)){
                $sql = "INSERT INTO produits (reference, prix, description, etat, id_depot)
                        VALUES ('".$params['reference']."','"
                                .$params['prix']."','"
                                .$params['description']."',
                                'En stock','"
                                .$idDepot."')";
                $insert = mysql_query($sql);
                if($insert){
                    $response = $response->withStatus(201, 'Product created');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $find = mysql_query('SELECT * FROM produits WHERE reference="'.$params['reference'].'"');
                    $depot = mysql_fetch_object($find);
                    $response = $response->write(json_encode($depot));
                }
                else{
                    echo'error insertion';
                }
            }else{
                $response = $response->withStatus(400, 'Reference deja utilisee');
            }
        } else {
            $response = $response->withStatus(400, 'Depot inexitant');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Permet d ajouter des produits dans une vente (non-implementer)
$app->post('/api/sells/{id_sell}/products', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    $collection = (new MongoClient())->depotsventes->sells;
    return $response;
});

//Permet de recuperer les produits d un depots -----> OK
$app->get('/api/depots/{id_depot}/products', function ($request, $response, $args) {
    $host='';
    $userdb='root';
    $pass='';
    $dbname='depotsventes';
    $idDepot = $args['id_depot'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $connectdb=mysql_connect($host, $userdb, $pass);
    $db=mysql_select_db($dbname);
    $produits = mysql_query('SELECT * FROM produits WHERE id_depot='.$idDepot);
    $depot = mysql_query('SELECT * FROM depots WHERE id='.$idDepot);
    if(mysql_num_rows($produits) !== 0)
    {
        while ($row = mysql_fetch_assoc($produits)) {
            $tab[] = $row;
        }
        $response = $response->write(json_encode($tab));
    } 
    if(mysql_num_rows($depot)==0) {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    return $response;
});


//Permet de recup les produits d une vente (non-implementer)
$app->get('/api/sells/{id_sell}/products', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $collection = (new MongoClient())->depotsventes->sells;
    return $response;
});