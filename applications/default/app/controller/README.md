#### ZnetDK 4 Mobile `./app/controller` directory
*This folder contains the custom application controllers.*    
For example:
````
<?php
namespace app\controller;

class MyController extends \AppController {
    
    static protected function action_myaction() {
        $response = new \Response();
        $response->setSuccessMessage(NULL, 'My success message.');
        return $response;
    }
}
````