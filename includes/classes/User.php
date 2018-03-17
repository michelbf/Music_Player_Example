<?php

namespace Slotify; 
use PDO;

class User {

    
    private $db;
    private $username;
    private $userId;
    
    public function __construct($db, $username) {
        $this->db = $db;
        $this->username = $username;
    }
    
    public function getUsername() {
        return $this->username;
    }

}
