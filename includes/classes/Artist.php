<?php
namespace Slotify;

use PDO;

class Artist
{

    private $db;
    private $songIDs;
    private $id;
    private $name;
   
    

    public function __construct($db, $id)
    {
        $this->db = $db;
        $this->id = $id;
        $this->songIDs = array();

        
        
//        $query_text = "
//                       SELECT songs.id as id, songs.title as title, songs.path as path, songs.albumOrder as albumOrder,  
//                              artists.name as artist, genres.name as genre, songs.duration as duration, 
//                              albums.title as album, songs.album as albumID, albums.artworkPath   
//                       FROM albums, artists, genres, songs  
//                       WHERE songs.id = :song_id 
//                       AND songs.artist = artists.id 
//                       AND songs.genre = genres.id 
//                       AND songs.album = albums.id
//                       ";

        $query_text = "
                       SELECT *   
                       FROM artists  
                       WHERE artists.id = :artist_id 
                       ";
        
        $query = $this->db->prepare($query_text);
        $result = $query->execute(array(':artist_id' => $this->id));
        $artist = $query->fetch();
        
        $this->name = $artist['name'];
        
    }

    public function getName()
    {
        return $this->name;
    }

    
    public function getSongIDs()
    {
        if ($this->songIDs == NULL){
            $songIDs = array();
            $query_text = "
                            SELECT id FROM songs  
                            WHERE artist = :artist_id 
                            ORDER BY plays DESC
                          ";
            $query =  $this->db->prepare($query_text);
            $results = $query->execute(array(":artist_id" => $this->id));

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                array_push($this->songIDs, $row['id']);
            }
        }
    
        return $this->songIDs;
       
    }
}
