<?php

function city($id = null)
{
    if ($id < 1) {
        $uri = "http://api.rajaongkir.com/starter/city";
    } else {
        $uri = "http://api.rajaongkir.com/starter/city?id=" . $id;
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: b5380484c85c53f8c58453ef0bcac858"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return $response;
    }
}
