# CakePHP Geocoder Plugin

This plugin adds a geocoder controller component and model behavior to your CakePHP application.

## Installation

To install, either clone this repository or add it add a submodule to your project. Both are done in a command line client from the root of your project.

### Cloning the repository

The simplest way is to clone the repository. The command for this is:

    $ git clone git@github.com:martinbean/cakephp-geocoder-plugin.git app/Plugin/Geocoder

### Adding as a submodule

Alternatively, you can add the behaviour as a submodule to your project if it’s already version-controlled with Git. To do this, run the following commands:

    $ git submodule add git@github.com:martinbean/cakephp-geocoding-plugin.git.git app/Plugin/Geocoding
    $ git submodule init

Once you have cloned/added the plugin as a submodule, you then need to enable it in your CakePHP application.
Add the following line to your **app/Config/bootstrap.php** file:

```php
CakePlugin::load('Geocoding');
```

Alternatively, you can just use the following if you have many plugins:

```php
CakePlugin::loadAll();
```

## Using the Component

You can use the component to geocode addresses within your controllers. A good example is if you need to take a user-submitted value and convert it to a latitude/longitude pair to pass to a model to search it.

To geocode an address in your controllers, simply do something similar to the following:

```php
<?php
class StoresController extends AppController {
    
    public $components = array(
        'Geocoder.Geocoder'
    );
    
    public function search() {
        
        $location = $this->request->query['location'];
        
        $geocodeResult = $this->Geocoder->geocode($location);
        
        if (count($geocodeResult) > 0) {
            $latitude = floatval($geocodeResult[0]->geometry->location->lat);
            $longitude = floatval($geocodeResult[0]->geometry->location->lng);
        }
    }
}
```

The component will return a response as a native PHP object from Google’s Geocoding API.

## Using the Behavior

There is also a model behavior. This is useful if saving a record and you want to create a latitude/longitude pair from a field in your model’s data that represents the address, for example a store. Simply attach the behavior to your model:

Then call it in your app’s models:

```php
<?php
class Store extends AppModel {
    
    public $name = 'Store';
    public $actsAs = array(
        'Geocoder.Geocodable'
    );
}
```

### Configuration

By default, the behavior assumes you have two columns in your corresponding database table called `latitude` and `longitude`, and also a column called `address`. These can be changed though. Simply pass an array of options when attaching the behavior:

```php
<?php
class Store extends AppModel {
    
    public $name = 'Store';
    public $actsAs = array(
        'Geocoder.Geocodable' => array(
            'addressColumn' => 'street_address',
            'latitudeColumn' => 'lat',
            'longitudeColumn' => 'lng'
        )
    );
}
```

The `addressColumn` key also accepts an array. If you pass an array for the value, then the behavior will go over each items and assemble the address that way. So if you store addresses as their separate components then you could do the following:

```php
<?php
class Store extends AppModel {
    
    public $name = 'Store';
    public $actsAs = array(
        'Geocoder.Geocodable' => array(
            'addressColumn' => array(
                'street_address',
                'locality',
                'postal_code'
            )
        )
    );
}
```

If you have any issues with this plugin then please feel free to create a new [Issue](https://github.com/martinbean/cakephp-geocoding-plugin/issues) on the [GitHub repository](https://github.com/martinbean/cakephp-geocoding-plugin). This plugin is licensed under the MIT License.
