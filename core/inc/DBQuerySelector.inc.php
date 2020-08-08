<!-- This is a class for querying and selecting information from the database. Change class name as appropriate
     including functions, depending on your needs. This class extend the DB class, thus includes the query() and
     select() menthods. -->
<?php
require 'core/inc/DB.inc.php';

class PILwall extends DB {
// beginning of class

    public function Getmemes() {

      $query = "SELECT * FROM meme_collection";

      $result = $this->select($query);

      return $result;
    }

    public function Getcatagories1() {

      $query = "SELECT DISTINCT cat1 FROM meme_collection";

      $result = $this->select($query);

      return $result;
    }

    public function Getcatagories2() {

      $query = "SELECT DISTINCT cat2 FROM meme_collection";

      $result = $this->select($query);

      return $result;
    }

    public function Getasso1() {

      $query = "SELECT DISTINCT asso1 FROM meme_collection";

      $result = $this->select($query);

      return $result;
    }

    public function getImgLoc() {

      $query = "SELECT url_loc FROM meme_collection WHERE cat1 = 'obama' AND asso1 = 'irony'";

      $result = $this->select($query);

      return $result;

    }

// end of class
}
?>
