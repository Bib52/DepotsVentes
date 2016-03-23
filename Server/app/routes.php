<?php
/* ------------------------------DEPOT------------------------------ */
//Recuperer le depot id ------>  OK
$app->get('/api/depots/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $depot=Depots::find($id);
    if (!empty($depot)) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($depot));
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    return $response;
});

//Recuperer tous les depots ------>  OK
$app->get('/api/depots', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $depots=Depots::all();
    if(count($depots)>0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($depots));
    } else {
        $response = $response->withStatus(404, 'Aucun depot enregistre');
    }
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
        $email=Depots::where('email', $params['email'])->first();
        if(count($email)==0){
            $idDepot = Depots::addDepot($params);
            $response = $response->withStatus(201, 'Depot created');
            $response = $response->withHeader('Content-Type', 'application/json');
            $find=Depots::find($idDepot);
            $response = $response->write(json_encode($find));
        }
        else {
            $response = $response->withStatus(400, 'email already use');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Modifier les information du deposant du dépot id ------>  OK
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
        $findDepot = Depots::find($id);
        if (!empty($findDepot)){
            $email = $findDepot->email;
            $findDepot->nom = $params['nom'];
            $findDepot->prenom = $params['prenom'];
            $findDepot->adresse = $params['adresse'];
            $findDepot->telephone = $params['telephone'];
            if ($email != $params['email']){
                $findEmail = Depots::where('email','=',$params['email'])->first();
                if(count($findEmail)==0){
                    $findDepot->email = $params['email'];
                    $findDepot->save();
                    $response = $response->withStatus(201, 'Product updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response = $response->write(json_encode($findDepot));
                }
                else{
                    $response = $response->withStatus(400, 'email already use');
                }
            }
            else{
                $findDepot->save();
                $response = $response->withStatus(201, 'Product updated');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($findDepot));   
            }
        }
        else{
            $response = $response->withStatus(400, 'Depot inexistant');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Supprimer le depot id (supprimer depot et produits du depot) ------>  OK
$app->delete('/api/depots/{id}', function ($request, $response, $args) {
    $idDepot = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $depot=Depots::find($idDepot);
    if (!empty($depot)) {
        $depot->delete();
        Produits::where('id_depot', "=", $idDepot)->delete();
        $response = $response->withStatus(200, 'Depot et produits supprimees');
    } else {
        $response = $response->withStatus(404, 'Depot inexistant');
    }
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
        $depot = Depots::find($idDepot);
        if(! empty($depot)){
            $produit = Produits::where('reference', '=', $params['reference'])->first();
            if (empty($produit)){
                $insert = Produits::addProduit($params, $idDepot);
                if($insert){
                    $response = $response->withStatus(201, 'Product created');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $product = Produits::where('reference', '=', $params['reference'])->first();
                    $response = $response->write(json_encode($product));
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

//Supprimer le produit id du depot id_depot ------>  OK
$app->delete('/api/depots/{id_depot}/products/{reference}', function ($request, $response, $args) {
    $idDepot = $args['id_depot'];
    $refProduct = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $depot = Depots::find($idDepot);
    if(!empty($depot)){
        $produit = Produits::where('reference','=',$refProduct)->where('id_depot','=',$idDepot)->get();
        if (count($produit)>0) {
            Produits::where('reference','=',$refProduct)->delete();
            $response = $response->withStatus(200, 'Product deleted');
        } else {
            $response = $response->withStatus(404, 'Reference produit inexistante dans ce depot');
        }
    } else{
        $response = $response->withStatus(400, 'Depot inexitant');    
    }
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
        && !empty($params['etat'])
    ) {
        $depot = Depots::find($idDepot);
        if ($depot){
            $produit = Produits::where('reference', '=', $refProduct)
                            ->where('id_depot', '=', $idDepot)->first();
            if($produit){
                $update = Produits::updateProduit($refProduct, $params);
                if($update){
                    $response = $response->withStatus(201, 'Product updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $produit = Produits::where('reference', '=', $refProduct)->first();
                    $response = $response->write(json_encode($produit));
                }
                else{
                    $response = $response->withStatus(201, 'Aucune modification realise');
                }
            }
            else {
                $response = $response->withStatus(400, 'Produit inexistant dans ce depot');
            }
        }
        else{
            $response = $response->withStatus(400, 'Depot inexistant');
        }
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
    $depot = Depots::find($idDepot);
    if(!empty($depot))
    {
        $produits = Produits::where('id_depot','=',$idDepot)->get();
        if(count($produits)>0){
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->write(json_encode($produits));
        }
        else{
            $response = $response->withStatus(404, 'Aucun produits');
        }
    } 
    else{
        $response = $response->withStatus(404, 'Depot inexistant');
    }
    return $response;
});

/* ------------------------------VENTE------------------------------ */
//Creer une vente ------>  OK
$app->post('/api/sales', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    $vente = Ventes::createVente();
    $find = Ventes::find($vente);
    $response = $response->withStatus(201, 'Vente created');
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->write(json_encode($find));
    return $response;
});

//Ajouter un produits dans une vente : produit (ref) dans la vente (id) ------>  OK
$app->put('/api/sales/{id_sale}/products/{ref}', function ($request, $response, $args) {
    $idSale = $args['id_sale'];
    $ref = $args['ref'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    $product = Produits::where('reference', '=', $ref)->first();
    if ($product) {
        $addProduit = Produits::addToVente($ref, $idSale);
        if($addProduit) {
            $product = Produits::where('reference', '=', $ref)->first();
            $response = $response->write(json_encode($product));
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->withStatus(200, 'Produit ajoute de la vente');
        }
        else{
            $response = $response->withStatus(400, 'Produit plus en stock');
        }
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    return $response;
});

//Recuperer les produits d'une vente ------>  Voir que faire quand produits est vide (supprimer la vente ou pas)
$app->get('/api/sales/{id_sale}/products', function ($request, $response, $args) {
    $idSale = $args['id_sale'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $vente = Ventes::find($idSale);
    if ($vente){
        $produits = Produits::where("id_vente","=",$idSale)->get();
        if(count($produits)>0){
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->write(json_encode($produits));
        }
        else{
            $response = $response->withStatus(404, 'Aucun produit dans cette vente');
        }
    }
    else{
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    return $response;
});

//Supprimer un produit dans une vente : produit (ref) de la vente (id) ------>  OK
$app->delete('/api/sales/{id_sale}/products/{ref}', function ($request, $response, $args) {
    $id_vente = $args['id_sale'];
    $ref = $args['ref'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $product = Produits::where('reference', '=', $ref)->where('id_vente', '=', $id_vente)->get();
    if (count($product) > 0) {
        $update = Produits::where('reference', '=', $ref)
                    ->update(['etat' => 'En stock',
                        'id_vente' => 0]);
        $response = $response->withStatus(200, 'Produit retire de la vente');
    } else {
        $response = $response->withStatus(404, 'Produit inexistant');
    }
    return $response;
});

//Recuperer la vente id : information acheteur ------>  OK
$app->get('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $vente = Ventes::find($id);
    if (!empty($vente)) {
        $response = $response->write(json_encode($vente));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    return $response;
});

//Ajouter les informations de l'acheteur à la vente id ------>  OK
$app->put('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    if (!empty($params['nom'])
        && !empty($params['prenom'])
        && !empty($params['adresse'])
        && !empty($params['ville'])
        && !empty($params['email'])
        && !empty($params['telephone'])
    ){
        $vente = Ventes::find($id);
        if($vente != null){
            $update = Ventes::addCoordonnees($id, $params);
            if($update){
                $response = $response->withStatus(201, 'Vente updated');
                $response = $response->withHeader('Content-Type', 'application/json');
                $vente = Ventes::find($id);
                $response = $response->write(json_encode($vente));
            }
            else{
                echo'error update';
            }
        } else {
            $response = $response->withStatus(400, 'Vente inexitanet');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Recuperer toute les ventes ------>  OK 
$app->get('/api/sales', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $ventes = Ventes::all();
    if(count($ventes) !== 0) {
        $response = $response->write(json_encode($ventes));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Aucune vente enregistre');
    }
    return $response;
});

//Supprimer la vente id ------>  OK
$app->delete('/api/sales/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $vente = Ventes::find($id);
    if (!empty($vente)) {
        Produits::where('id_vente', '=', $id)
                ->update(['etat' => 'En stock', 
                        'id_vente' => 0]);
        Paiements::where('id_vente', "=", $id)->delete();
        $vente->delete();
        $response = $response->withStatus(200, 'Vente deleted');
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    return $response;
});

/* ------------------------------PAIEMENT VENTE------------------------------ */
//Ajouter un paiement à une vente ------> OK
$app->post('/api/sales/{id_sale}/payments', function ($request, $response, $args) {
    $id = $args['id_sale'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['prix'])
        && !empty($params['mode_paiements'])
    ) {    
        $vente = Ventes::find($id);
        if ($vente) {
            $vente->etat = 'Finie';
            $vente->save();
            $produits = Produits::where("id_vente","=",$id)->update(['etat' => 'Vendu']);
            $idpaiement = Paiements::addPaiement($params, $id);
            if($idpaiement){
                $paiement = Paiements::find($idpaiement);
                $response = $response->withStatus(201, 'paiement enregistre');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($paiement));
            }
            else{
                echo'error insertion';
            }
        } else {
            $response = $response->withStatus(404, 'Vente inexistante');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Recuperer paiement effectuer sur la vente id ------>  OK
$app->get('/api/sales/{id_sale}/payments', function ($request, $response, $args) {
    $id = $args['id_sale'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $ventes = Ventes::find($id);
    if(!empty($ventes)) {
        $paiement = Paiements::where("id_vente","=",$id)->first();
        if(count($paiement)>0) {
            $response = $response->write(json_encode($paiement));
            $response = $response->withHeader('Content-Type', 'application/json');
        } else {
        $response = $response->withStatus(404, 'Paiement inexistant');
        }
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    return $response;
});

//Supprimer un paiement ------>  OK
$app->delete('/api/sales/{id_sale}/payments', function ($request, $response, $args) {
    $id = $args['id_sale'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $vente = Ventes::find($id);
    if($vente){
        $paiement = Paiements::where("id_vente","=",$id)->first();
        if ($paiement) {
            Paiements::where("id_vente","=",$id)->delete();
            $response = $response->withStatus(200, 'Paiment supprime');
        } else {
            $response = $response->withStatus(404, 'Paiment inexistant');
        }
    } else {
        $response = $response->withStatus(404, 'Vente inexistante');
    }
    return $response;
});


/* ------------------------------MODE DE PAIEMENT------------------------------ */
//Recuperer les modes de paiements ------>  OK
$app->get('/api/payments', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $modePaiement = ModePaiements::all();
    if(count($modePaiement) > 0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($modePaiement));
    } else {
        $response = $response->withStatus(404, 'Aucun mode de paiement enregistre');
    }
    return $response;
});

//Ajouter un mode de paiement ------> OK
$app->post('/api/payments', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['nom'])){
        $insert = ModePaiements::addModePaiement($params);
        if($insert != false){
            $response = $response->withStatus(201, 'Mode de paiement ajoute');
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->write(json_encode($insert));
        }
        else{
            echo'error insertion';
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Modifier un mode de paiement ------> OK
$app->put('/api/payments/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    if (!empty($params['nom']))
    {
        $modePaiement = ModePaiements::find($id);
        if($modePaiement){
            $mdPaiement = ModePaiements::updateModePaiement($id, $params);
            if($mdPaiement){
                $response = $response->withStatus(201, 'Mode de paiement modifie');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($mdPaiement));
            }
            else{
                echo'error update';
            }
        } else {
            $response = $response->withStatus(404, 'Mode de paiement inexistant');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Supprimer un mode de paiement ------> OK
$app->delete('/api/payments/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $modePaiement = ModePaiements::find($id);
    if ($modePaiement) {
        $modePaiement->delete();
        $response = $response->withStatus(200, 'Mode de paiement supprime');
    } else {
        $response = $response->withStatus(404, 'Mode de paiement inexistant');
    }
    return $response;
});

/* ------------------------------PRODUITS------------------------------ */
//Recuperer tous les produits ------>  OK
$app->get('/api/products', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $produits=Produits::all();
    if(count($produits) !== 0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($produits));
    } else {
        $response = $response->withStatus(404, 'Aucun produit enregistre');
    }
    return $response;
});

//Recuperer le produit ref ------>  OK
$app->get('/api/products/{reference}', function ($request, $response, $args) {
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $produit=Produits::where('reference', $reference)->first();
    if (count($produit)>0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($produit));
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    return $response;
});

//Supprimer le produit ref ------>  OK
$app->delete('/api/products/{reference}', function ($request, $response, $args) {
    $reference = $args['reference'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $produit = Produits::where('reference', $reference)->first();
    if (count($produit)>0) {
        Produits::where('reference', $reference)->delete();
        $response = $response->withStatus(200, 'Product deleted');
    } else {
        $response = $response->withStatus(404, 'Reference produit inexistante');
    }
    return $response;
});

/* ------------------------------STAFFS------------------------------ */
//Recuperer les membres du staff ------>  OK
$app->get('/api/staffs', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $staff=Staff::all();
    if(count($staff)>0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($staff));
    } else {
        $response = $response->withStatus(404, 'Aucun staff enregistre');
    }
    return $response;
});

//Ajouter un membre du staff ------>  OK
$app->post('/api/staffs', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['nom'])
        && !empty($params['login'])
        && !empty($params['password'])
        && !empty($params['permission'])
    ){
        $findLogin = Staff::where("login","=",$params['login'])->first();
        if(empty($findLogin)){
            $insert = Staff::addStaff($params);
            if($insert != false){
                $response = $response->withStatus(201, 'Staff ajoute');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($insert));
            }
            else{
                echo'error insertion';
            }
        } else{
            $response = $response->withStatus(400, 'Login deja utilise');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Supprimer un membre du staff ------>  OK
$app->delete('/api/staffs/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "DELETE");
    $staff=Staff::find($id);
    if (!empty($staff)) {
        $staff->delete();
        $response = $response->withStatus(200, 'Staff deleted');
    } else {
        $response = $response->withStatus(404, 'Staff inexistant');
    }
    return $response;
});

//Modifier un membre du staff --> OK
$app->put('/api/staffs/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    if (!empty($params['nom'])
        && !empty($params['login'])
        && !empty($params['password'])
        && !empty($params['permission'])
    ) {
        $findStaff = Staff::find($id);
        if (!empty($findStaff)){
            $login = $findStaff->login;
            $findStaff->nom = $params['nom'];
            $findStaff->password = password_hash($params['password'], PASSWORD_DEFAULT);
            $findStaff->permission = $params['permission'];
            if ($login != $params['login']){
                $findLogin = Staff::where("login","=",$params['login'])->first();
                if(count($findLogin)==0){
                    $findStaff->login = $params['login'];
                    $findStaff->save();
                    $response = $response->withStatus(201, 'Staff updated');
                    $response = $response->withHeader('Content-Type', 'application/json');
                    $response = $response->write(json_encode($findStaff));
                }
                else{
                    $response = $response->withStatus(400, 'login already use');
                }
            }
            else{
                $findStaff->save();
                $response = $response->withStatus(201, 'Staff updated');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($findStaff));   
            }
        }
        else{
            $response = $response->withStatus(400, 'Staff inexistant');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

/* ------------------------------COMMISSIONS------------------------------ */
//Recuperer toutes les configurations ------>  OK
$app->get('/api/configurations', function ($request, $response) {
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $conf=Configurations::all();
    if(count($conf)>0) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($conf));
    } else {
        $response = $response->withStatus(404, 'Aucune configuration enregistre');
    }
    return $response;
});

//Recuperer la configuration id ------>  OK
$app->get('/api/configurations/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $conf=Configurations::find($id);
    if(!empty($conf)) {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->write(json_encode($conf));
    } else {
        $response = $response->withStatus(404, 'Configuration inexistante');
    }
    return $response;
});

//Modifier la configuration id ------>  OK
$app->put('/api/configurations/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "PUT");
    if (!empty($params['valeur'])
    ) {
        $conf=Configurations::find($id);
        if(!empty($conf)) {
            $conf->valeur = $params['valeur'];
            $conf->save();
            $response = $response->withStatus(201, 'Commission updated');
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->write(json_encode($conf));   
        } else {
            $response = $response->withStatus(404, 'Configuration inexistante');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

/* ------------------------------CONNEXION------------------------------ */

//Connecter un membre du staff
$app->post('/api/staffs/signin', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['login'])
        && !empty($params['password'])
    ){
        $findLogin = Staff::where("login","=",$params['login'])->first();
        if(!empty($findLogin)){
            $connect = Staff::connexion($params);
            if($connect != false){
                $response = $response->withStatus(201, 'Staff connecte');
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->write(json_encode($connect));
            }
            else{
                $response = $response->withStatus(400, 'Erreur Password');
            }
        } else{
            $response = $response->withStatus(400, 'Erreur Login');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});