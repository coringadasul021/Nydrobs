<?php
function getAmadeusToken() {
    $client_id = 'HX3OEuRxeibKBEvISCVH5pwl6YObVzqA';
    $client_secret = 'WjMzNUGTGMolFXdj';

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://test.api.amadeus.com/v1/security/oauth2/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ]),
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    return $data['access_token'] ?? null;
}
