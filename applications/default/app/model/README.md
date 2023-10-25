#### ZnetDK 4 Mobile `./app/model` directory
*This folder contains the custom application controllers.*    
For example:
````
<?php
namespace app\model;

class MyModel extends \DAO {
    
    protected function initDaoProperties() {
        $this->table = "my_table";
    }
}
````
