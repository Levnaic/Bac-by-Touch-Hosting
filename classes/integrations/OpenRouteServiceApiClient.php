<?php

namespace BacByTouch;

class OpenRouteServiceApiClient extends BaseApiClient
{
    public function __construct($apiKey)
    {
        parent::__construct($apiKey);
    }

    public function getDirectionsCar($start, $end)
    {
        $response = $this->callApi(
            'https://api.openrouteservice.org/ors/v2/directions/driving-car',
            array(
                'api_key' => $this->apiKey,
                'start' => $start,
                'end' => $end
            )
        );
        return $response;
    }

    public function getDirectionsFoot($start, $end)
    {
        $response = $this->callApi(
            'https://api.openrouteservice.org/ors/v2/directions/foot-walking',
            array(
                'api_key' => $this->apiKey,
                'start' => $start,
                'end' => $end
            )
        );
        return $response;
    }

    public function getDirectionsBike($start, $end)
    {
        $response = $this->callApi(
            'https://api.openrouteservice.org/ors/v2/directions/cycling-regular',
            array(
                'api_key' => $this->apiKey,
                'start' => $start,
                'end' => $end
            )
        );
        return $response;
    }
};
