<?php
namespace App\Service;

use GuzzleHttp\Client;

class GooglePlacesService
{
    private $client;
    private $apiKey;

    public function __construct(string $googlePlacesApiKey)
    {
        $this->client = new Client();
        $this->apiKey = $googlePlacesApiKey;
    }

    public function getCoordinatesFromPlaceId(string $placeId): ?array
    {
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/place/details/json?place_id=%s&key=%s',
            $placeId,
            $this->apiKey
        );

        $response = $this->client->get($url);
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] !== 'OK') {
            return null;
        }

        $coordinates = $data['result']['geometry']['location'];
        return [
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
        ];
    }
    //plcae id from lat and long
    public function getPlaceIdFromCoordinates(float $latitude, float $longitude): ?string
    {
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=%s,%s&inputtype=textquery&fields=place_id&key=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->get($url);
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] !== 'OK') {
            return null;
        }

        return $data['candidates'][0]['place_id'];
    }
}
