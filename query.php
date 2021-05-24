<?php
require_once "./vendor/autoload.php";
\EasyRdf\RdfNamespace::set('p', 'http://www.rekomobi.com');
\EasyRdf\RdfNamespace::set('d', 'http://www.rekomobi.com/dataset/data#');


function search(
    $keywords,
    $sortByHargaAsc = false,
    $sortByHargaDesc = false,
    $sortByRatingAsc = false,
    $sortByRatingDesc = false
) {
    $sortQuery = "";
    if ($sortByHargaAsc) $sortQuery = "ORDER BY ASC(?harga)";
    if ($sortByHargaDesc) $sortQuery = "ORDER BY DESC(?harga)";
    if ($sortByRatingAsc) $sortQuery = "ORDER BY ASC(?rating)";
    if ($sortByRatingDesc) $sortQuery = "ORDER BY DESC(?rating)";

    $sparql = new \EasyRdf\Sparql\Client("https://ee97bb940262.ngrok.io/rekomobi-dev");
    $results = $sparql->query("SELECT ?x ?merek ?nama ?jenis ?harga ?rating 
    WHERE { {
            LET ( ?merek := '" . $keywords . "' )
            ?x d:merek ?merek .
            ?x d:nama ?nama .
            ?x d:jenis ?jenis .
            ?x d:harga ?harga .
            ?x d:rating ?rating . }
    UNION { LET ( ?nama := '" . $keywords . "' )
            ?x d:nama ?nama .
            ?x d:merek ?merek .
            ?x d:jenis ?jenis .
            ?x d:harga ?harga .  
            ?x d:rating ?rating . } 
    UNION { LET ( ?jenis := '" . $keywords . "' )
            ?x d:jenis ?jenis .
            ?x d:nama ?nama .
            ?x d:merek ?merek .  
            ?x d:harga ?harga . 
            ?x d:rating ?rating . }} ".$sortQuery);

    return $results;
}

function recommend($formData){
    $jenis = $formData['jenis'];
    $hargaMin = $formData['hargaMin'];
    $hargaMax = $formData['hargaMax'];

    $sparql = new \EasyRdf\Sparql\Client("https://ee97bb940262.ngrok.io/rekomobi-dev");
    $results = $sparql->query("SELECT ?x ?merek ?nama ?jenis ?harga ?rating 
    WHERE { 
        LET ( ?jenis := '".$jenis."' )
        ?x d:jenis ?jenis .
        ?x d:merek ?merek .
        ?x d:nama ?nama  .
        ?x d:harga ?harga .
        ?x d:rating ?rating . 
        FILTER (?harga > ".$hargaMin.".&& ?harga < ".$hargaMax.").
        }");

    return $results;
}
