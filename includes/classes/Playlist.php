<?php

namespace Slotify; 
use PDO;

class Playlist {
    
    private $db;
    private $name;
    private $id;
    private $user;
    private $dateCreated;
    
    public function __construct($db, $playlistData) {
        $this->db = $db;
        
        if(!is_array($playlistData)) {
           $query_text = "
                        SELECT * FROM playlists  
                        WHERE id = :playlistId
                      ";
            $query =  $this->db->prepare($query_text); 
            $result = $query->execute(array(":playlistId" => $playlistData));
            $playlistData = $query->fetch();
        }
        
        $this->name = $playlistData['name'];
        $this->id = $playlistData['id'];
        $this->user = $playlistData['user'];
        $this->dateCreated = $playlistData['dateCreated'];
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNumberOfSongs() {

        $query_text = "
                        SELECT COUNT(*) from playlistsongs  
                        WHERE playlistId = :playlistId  
                        ";
        $query = $this->db->prepare($query_text);
        $result = $query->execute(array(":playlistId" => $this->id));
        $numberOfSongs = $query->fetch();

        return $numberOfSongs["COUNT(*)"];

    }
    
    public function getSongIDs()
    {
        $songIDs = array();
        $query_text = "
                        SELECT songId FROM playlistsongs  
                        WHERE playlistId = :playlistId 
                        ORDER BY id ASC
                      ";
        $query =  $this->db->prepare($query_text);
        $results = $query->execute(array(":playlistId" => $this->id));
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push($songIDs, $row['songId']);
        }
        
        return $songIDs;
       
    }
    
   

}
