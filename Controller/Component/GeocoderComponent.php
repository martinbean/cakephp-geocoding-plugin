<?php
App::uses('HttpSocket', 'Network/Http');

class GeocoderComponent extends Component {
    
    /**
     * Geocodes an address.
     *
     * @param string $address
     * @param array $parameters
     * @return object
     * @todo Determine what to do if response status is an error
     */
    public function geocode($address, $parameters = array()) {
        
        $parameters['address'] = $address;
        $parameters['sensor'] = 'false';
        
        $url = 'http://maps.googleapis.com/maps/api/geocode/json';
        
        $http = new HttpSocket();
        
        $response = $http->get($url, $parameters);
        $response = json_decode($response);
        
        return $response->results;
    }
}