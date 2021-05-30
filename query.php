<?php
require_once "./vendor/autoload.php";
\EasyRdf\RdfNamespace::set('p', 'http://www.rekomobi.com');
\EasyRdf\RdfNamespace::set('d', 'http://www.rekomobi.com/dataset/data#');
$last_word = "";

function search_word($word, $sortBy)
{
    $sortQuery = "";
    switch ($sortBy) {
        case "harga-asc":
            $sortQuery = "ORDER BY ASC(?harga)";
            break;

        case "harga-desc":
            $sortQuery = "ORDER BY DESC(?harga)";
            break;

        case "rating-asc":
            $sortQuery = "ORDER BY ASC(?rating)";
            break;

        case "rating-desc":
            $sortQuery = "ORDER BY DESC(?rating)";
            break;

        default:
            $sortQuery = "";
    }

    $sparql = new \EasyRdf\Sparql\Client("http://localhost:3030/rekomobi-dev");
    $search_results = $sparql->query("SELECT ?x ?merek ?nama ?jenis ?harga ?rating 
    WHERE {
            {
                ?x d:merek ?merek .
                ?x d:nama ?nama .
                ?x d:jenis ?jenis .
                ?x d:harga ?harga .
                ?x d:rating ?rating .
                FILTER regex(?merek, '". $word . "', 'i') .
            }
            
            UNION
            {
                ?x d:merek ?merek .
                ?x d:nama ?nama .
                ?x d:jenis ?jenis .
                ?x d:harga ?harga .
                ?x d:rating ?rating .
                FILTER regex(?nama, '". $word . "', 'i') .
            }

            UNION
            {
                ?x d:merek ?merek .
                ?x d:nama ?nama .
                ?x d:jenis ?jenis .
                ?x d:harga ?harga .
                ?x d:rating ?rating .
                FILTER regex(?jenis, '". $word . "', 'i') .
            }
            
        }" . $sortQuery);

    return $search_results;
}

function recommend($jenis, $hargaMin, $hargaMax, $sortBy)
{
    $sortQuery = "";
    switch ($sortBy) {
        case "harga-asc":
            $sortQuery = "ORDER BY ASC(?harga)";
            break;

        case "harga-desc":
            $sortQuery = "ORDER BY DESC(?harga)";
            break;

        case "rating-asc":
            $sortQuery = "ORDER BY ASC(?rating)";
            break;

        case "rating-desc":
            $sortQuery = "ORDER BY DESC(?rating)";
            break;

        default:
            $sortQuery = "";
    }

    $sparql = new \EasyRdf\Sparql\Client("http://localhost:3030/rekomobi-dev");
    $recommend_results = $sparql->query("SELECT ?x ?merek ?nama ?jenis ?harga ?rating 
    WHERE { 
        LET ( ?jenis := '" . $jenis . "' )
        ?x d:jenis ?jenis .
        ?x d:merek ?merek .
        ?x d:nama ?nama  .
        ?x d:harga ?harga .
        ?x d:rating ?rating . 
        FILTER (?harga > " . $hargaMin . " && ?harga < " . $hargaMax . ").
        }" . $sortQuery);

    return $recommend_results;
}