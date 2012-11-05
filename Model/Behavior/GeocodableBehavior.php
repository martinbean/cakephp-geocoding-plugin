<?php
App::uses('HttpSocket', 'Network/Http');

class GeocodableBehavior extends ModelBehavior {
    
    public $settings = array();
    
    public function setup(Model $Model, $settings = array()) {
        if (!isset($this->settings[$Model->alias])) {
            $this->settings[$Model->alias] = array(
                'latitude_column' => 'latitude',
                'longitude_column' => 'longitude',
                'region' => 'uk'
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array) $settings);
    }
    
    public function beforeSave(Model $Model) {
        $address_components = array();
        if (!is_null($Model->data[$Model->alias]['street_address'])) {
            $address_components[] = $Model->data[$Model->alias]['street_address'];
        }
        if (!is_null($Model->data[$Model->alias]['locality'])) {
            $address_components[] = $Model->data[$Model->alias]['locality'];
        }
        if (!is_null($Model->data[$Model->alias]['postal_code'])) {
            $address_components[] = $Model->data[$Model->alias]['postal_code'];
        }
        $address_string = implode(', ', $address_components);
        
        $parameters = array(
            'address' => $address_string,
            'region' => $this->settings[$Model->alias]['region'],
            'sensor' => 'false'
        );
        $http = new HttpSocket();
        $response = json_decode($http->get('http://maps.googleapis.com/maps/api/geocode/json', $parameters));
        
        if ($response->status == 'OK') {
            $Model->data[$Model->alias]['latitude'] = $response->results[0]->geometry->location->lat;
            $Model->data[$Model->alias]['longitude'] = $response->results[0]->geometry->location->lng;
            return true;
        }
    }
}