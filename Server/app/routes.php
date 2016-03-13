<?php
/* ------------------------------DEPOT------------------------------ */
//Recuperer le depot id ------>  OK
$app->get('/api/depots/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $depot = mysql_query('SELECT * FROM depots WHERE id='.$id);
    $obj = mysql_fetch_object($depot);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    require 'app/closedb.php';
    return $response;
});

//Recuperer tous les depots ------>  OK
$app->get('/api/depots', function ($request, $response, $args) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $produits = mysql_query('SELECT * FROM depots');
    if(mysql_num_rows($produits) !== 0) {
        while ($row = mysql_fetch_assoc($produits)) {
            $tab[] = $row;
        }
        $response = $response->write(json_encode($tab));
    } else {
        $response = $response->withStatus(404, 'Aucun depot enregistre');
    }
    require 'app/closedb.php';
    return $response;
});

//Creer un depot ------>  OK
$app->post('/api/depots', function ($request, $response) {
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
        require 'app/config.php';
        require 'app/opendb.php';
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
        require 'app/closedb.php';
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Modifier les information du desposant du dépot id
$app->put('/api/depots/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");

    if (!empty($params['nom'])
        && !empty($params['prenom'])
        && !empty($params['email'])
        && !empty($params['adresse'])
        && !empty($params['telephone'])
    ) {
        require 'app/config.php';
        require 'app/opendb.php';
        $findDepot = mysql_query('SELECT * FROM depots WHERE id="'.$id.'"');
        $res = mysql_fetch_object($findDepot);
        if ($res)
        {
            $findEmail = mysql_query('SELECT * FROM depots WHERE email="'.$params['email'].'"');
            $obj = mysql_fetch_object($findEmail);
            if($params['email'] !== $res->email && !$obj){
                $sql = "UPDATE depots SET nom='".$params['nom']."',
                                    prenom='".$params['prenom']."',
                                    email='".$params['email']."',
                                    adresse='".$params['adresse']."',
                                    telephone='".$params['telephone']."' 
                                    WHERE id='".$id."'"; 
                $update = mysql_query($sql);
                if($update){
                    $response = $response->withStatus(201, 'Product updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $find = mysql_query('SELECT * FROM depots WHERE id="'.$id.'"');
                    $depot = mysql_fetch_object($find);
                    $response = $response->write(json_encode($depot));
                }
                else{
                    echo'error update';
                }
            }
            elseif($params['email'] == $res->email){
                $sql = "UPDATE depots SET nom='".$params['nom']."',
                                    prenom='".$params['prenom']."',
                                    adresse='".$params['adresse']."',
                                    telephone='".$params['telephone']."' 
                                    WHERE id='".$id."'"; 
                $update = mysql_query($sql);
                if($update){
                    $response = $response->withStatus(201, 'Depot updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $find = mysql_query('SELECT * FROM depots WHERE id="'.$id.'"');
                    $depot = mysql_fetch_object($find);
                    $response = $response->write(json_encode($depot));
                }
                else{
                    echo'error update';
                }
            }
            else {
                $response = $response->withStatus(400, 'email already use');
            }
        }
        else{
            $response = $response->withStatus(400, 'Depot inexistant');
        }
        require 'app/closedb.php';
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Supprimer le depot id (supprimer depot et produits du depot)
$app->delete('/api/depots/{id}', function ($request, $response, $args) {
    $idDepot = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    require 'app/config.php';
    require 'app/opendb.php';
    $produit = mysql_query('SELECT * FROM depots WHERE id='.$idDepot);
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        $depot = mysql_query('DELETE FROM depots WHERE id='.$idDepot);
        $produit = mysql_query('DELETE FROM produits WHERE id_depot='.$idDepot);
        $response = $response->withStatus(200, 'Depot et produits supprimees');
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    require 'app/closedb.php';
    return $response;
});

//Ajouter des produits dans un depots ------>  OK
$app->post('/api/depots/{id_depot}/products', function ($request, $response, $args) {
    $idDepot = $args['id_depot'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['reference'])
        && !empty($params['prix'])
        && !empty($params['description'])
    ) {    
        require 'app/config.php';
        require 'app/opendb.php';
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
        require 'app/closedb.php';
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Supprimer le produit id du depot id_depot ------>  OK
$app->delete('/api/depots/{id_depot}/products/{reference}', function ($request, $response, $args) {
    $idDepot = $args['id_depot'];
    $refProduct = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    require 'app/config.php';
    require 'app/opendb.php';
    $depot = mysql_query('SELECT * FROM depots WHERE id='.$idDepot);
    $findDepot = mysql_fetch_object($depot);
    if($findDepot){
        $produit = mysql_query('SELECT * FROM produits WHERE reference='.$refProduct);
        $obj = mysql_fetch_object($produit);
        if ($obj) {
            $produit = mysql_query('DELETE FROM produits WHERE reference='.$refProduct);
            $response = $response->withStatus(200, 'Product deleted');
        } else {
            $response = $response->withStatus(404, 'Reference produit inexistante');
        }
    } else{
        $response = $response->withStatus(400, 'Depot inexitant');    
    }
    require 'app/closedb.php';
    return $response;
});

//Modifier le produit id du depot id_depot ------>  OK
$app->put('/api/depots/{id_depot}/products/{reference}', function ($request, $response, $args) {
    $idDepot = $args['id_depot'];
    $refProduct = $args['reference'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    if (!empty($params['prix'])
        && !empty($params['description'])
    ) {
        require 'app/config.php';
        require 'app/opendb.php';
        $findDepot = mysql_query('SELECT * FROM depots WHERE id="'.$idDepot.'"');
        $res = mysql_fetch_object($findDepot);
        if ($res)
        {
            $findProduct = mysql_query('SELECT * FROM produits WHERE reference="'.$refProduct.'"');
            $obj = mysql_fetch_object($findProduct);
            if($obj){
                $sql = "UPDATE produits SET prix='".$params['prix']."',
                                    description='".$params['description']."' 
                                    WHERE reference='".$refProduct."'"; 
                $update = mysql_query($sql);
                if($update){
                    $response = $response->withStatus(201, 'Product updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $find = mysql_query('SELECT * FROM produits WHERE reference="'.$refProduct.'"');
                    $depot = mysql_fetch_object($find);
                    $response = $response->write(json_encode($depot));
                }
                else{
                    echo'error update';
                }
            }
            else {
                $response = $response->withStatus(400, 'Produit inexistant');
            }
        }
        else{
            $response = $response->withStatus(400, 'Depot inexistant');
        }
        require 'app/closedb.php';
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Recuperer les produits d un depots -----> OK
$app->get('/api/depots/{id_depot}/products', function ($request, $response, $args) {
    $idDepot = $args['id_depot'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
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
    require 'app/closedb.php';
    return $response;
});

/* ------------------------------VENTE------------------------------ */
//Creer une vente
$app->post('/api/sales', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    require 'app/config.php';
    require 'app/opendb.php';
    $sql = "INSERT INTO ventes (nom, prenom, adresse, ville, email, telephone, etat)
                    VALUES ('','','','','','', 'En cours')";
    $insert = mysql_query($sql);
    if($insert){
        $response = $response->withStatus(201, 'Vente created');
    }
    else{
        echo'error insertion';
    } 
    require 'app/closedb.php';
    return $response;
});

//Ajouter des produits dans une vente
$app->post('/api/sales/{id_sale}/products', function ($request, $response, $args) {
    $idSale = $args['id_sale'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    require 'app/config.php';
    require 'app/opendb.php';
    //requete insert produit dans vente, changer etat produit de "en stock" à "en cours de vente"
    require 'app/closedb.php';
    return $response;
});

//Recuperer les produits d'une vente
$app->get('/api/sales/{id_sale}/products', function ($request, $response, $args) {
    $idSale = $args['id_sale'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $vente = mysql_query('SELECT * FROM ventes WHERE id ='.$idSale);
    $produits = mysql_query('SELECT * FROM produits WHERE id_vente='.$idSale);
    if(mysql_num_rows($produits) !== 0)
    {
        while ($row = mysql_fetch_assoc($produits)) {
            $tab[] = $row;
        }
        $response = $response->write(json_encode($tab));
    } 
    if(mysql_num_rows($vente)==0) {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    require 'app/closedb.php';
    return $response;
});

//Supprimer un produit dans une vente
$app->delete('/api/sales/{id_sale}/products/{id}', function ($request, $response, $args) {
    $id_vente = $args['id_sale'];
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    require 'app/config.php';
    require 'app/opendb.php';
    $produit = mysql_query('SELECT * FROM produits WHERE reference="'.$id.'" AND id_vente="'.$id_vente.'"');
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        // remettre le produits avec id_vente=0 et etat=en stock
        // $sql = "UPDATE produits SET etat='En stock',
        //                             id_vente=0 
        //                             WHERE id='".$id."'"; 
        // $update = mysql_query($sql);
        $response = $response->withStatus(200, 'Produit retiré de la vente');
    } else {
        $response = $response->withStatus(404, 'Produit inexistant');
    }
    require 'app/closedb.php';
    return $response;
});

//Recuperer la vente id : information acheteur ------>  OK
$app->get('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $vente = mysql_query('SELECT * FROM ventes WHERE id='.$id);
    $obj = mysql_fetch_object($vente);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    require 'app/closedb.php';
    return $response;
});

//Ajouter les informations de l'acheteur à la vente id ------>  OK
$app->post('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
     if (!empty($params['nom'])
        && !empty($params['prenom'])
        && !empty($params['adresse'])
        && !empty($params['ville'])
        && !empty($params['email'])
        && !empty($params['telephone'])
    ) {    
        require 'app/config.php';
        require 'app/opendb.php';
        $vente = mysql_query('SELECT * FROM ventes WHERE id='.$id);
        $obj = mysql_fetch_object($vente);
        if(! empty($obj)){
            
            $sql = "UPDATE ventes SET nom='".$params['nom']."',
                                    prenom='".$params['prenom']."',
                                    adresse='".$params['adresse']."',
                                    ville='".$params['ville']."',
                                    email='".$params['email']."',
                                    telephone='".$params['telephone']."'
                                WHERE id='".$id."'"; 
            $update = mysql_query($sql);
            if($update){
                $response = $response->withStatus(201, 'Vente updated');
                $response = $response->withHeader('Content-Type', 'application/json');
                $find = mysql_query('SELECT * FROM ventes WHERE id='.$id);
                $vente = mysql_fetch_object($find);
                $response = $response->write(json_encode($vente));
            }
            else{
                echo'error insertion';
            }
        } else {
            $response = $response->withStatus(400, 'Vente inexitanet');
        }
        require 'app/closedb.php';
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Recuperer toute les ventes ------>  OK 
$app->get('/api/sales', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $vente = mysql_query('SELECT * FROM ventes');
    if(mysql_num_rows($vente) !== 0) {
        while ($row = mysql_fetch_assoc($vente)) {
            $tab[] = $row;
        }
        $response = $response->write(json_encode($tab));
    } else {
        $response = $response->withStatus(404, 'Aucun depot enregistre');
    }
    require 'app/closedb.php';
    return $response;
});

//Supprimer la vente id
$app->delete('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    require 'app/config.php';
    require 'app/opendb.php';
    $vente = mysql_query('SELECT * FROM ventes WHERE id='.$id);
    $obj = mysql_fetch_object($vente);
    if ($obj) {
        // remettre les produits avec id_vente=0 et etat=en stock
        // $sql = "UPDATE produits SET etat='En stock',
        //                             id_vente=0 
        //                             WHERE id='".$id."'"; 
        // $update = mysql_query($sql);
        // $produits = mysql_query('SELECT * FROM produits WHERE id_vente='.$id);
        $v = mysql_query('DELETE FROM ventes WHERE id='.$id);
        $response = $response->withStatus(200, 'Vente deleted');
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    require 'app/closedb.php';
    return $response;
});

/* ------------------------------PRODUITS------------------------------ */
//Recuperer tous les produits ------>  OK
$app->get('/api/products', function ($request, $response, $args) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $produits = mysql_query('SELECT * FROM produits');
    if(mysql_num_rows($produits) !== 0) {
        while ($row = mysql_fetch_assoc($produits)) {
            $tab[] = $row;
        }
        $response = $response->write(json_encode($tab));
    } else {
        $response = $response->withStatus(404, 'Aucun produit enregistre');
    }
    require 'app/closedb.php';
    return $response;
});

//Recuperer le produit ref ------>  OK
$app->get('/api/products/{reference}', function ($request, $response, $args) {
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    require 'app/config.php';
    require 'app/opendb.php';
    $produit = mysql_query('SELECT * FROM produits WHERE reference='.$reference);
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        $response = $response->write(json_encode($obj));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    require 'app/closedb.php';
    return $response;
});

//Supprimer le produit ref ------>  OK
$app->delete('/api/products/{reference}', function ($request, $response, $args) {
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    require 'app/config.php';
    require 'app/opendb.php';
    $produit = mysql_query('SELECT * FROM produits WHERE reference='.$reference);
    $obj = mysql_fetch_object($produit);
    if ($obj) {
        $produit = mysql_query('DELETE FROM produits WHERE reference='.$reference);
        $response = $response->withStatus(200, 'Product deleted');
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    require 'app/closedb.php';
    return $response;
});
