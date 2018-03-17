<?php
namespace Slotify;

use PDO;

class Album
{

    private $db;

    private $id;
    private $title;
    private $artistID;
    private $artist;
    private $genreID;
    private $genre;
    private $artworkPath;

    public function __construct($db, $id)
    {
        $this->db = $db;
        $this->id = $id;

        $query_text = "
                       SELECT albums.id as id, albums.title as title, albums.artist as artistID, 
                              artists.name as artist, albums.genre as genreID, genres.name as genre, 
                              albums.artworkPath as artworkPath  
                       FROM albums, artists, genres 
                       WHERE albums.id = :album_id 
                       AND albums.artist = artists.id 
                       AND albums.genre = genres.id
                       ";

        $query = $this->db->prepare($query_text);
        $result = $query->execute(array(':album_id' => $this->id));

        $album = $query->fetch();
        $this->title = $album['title'];
        $this->artistID = $album['artistID'];
        $this->artist = $album['artist'];
        $this->genreID = $album['genreID'];
        $this->genre = $album['genre'];
        $this->artworkPath = $album['artworkPath'];

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getArtworkPath()
    {
        return $this->artworkPath;
    }


    public function getNumberofSongs()
    {

        $query_text = "
                        SELECT COUNT(*) from songs  
                        WHERE album = :album_id 
                        ";
        $query = $this->db->prepare($query_text);
        $result = $query->execute(array(":album_id" => $this->id));
        $numberOfSongs = $query->fetch();

        return $numberOfSongs["COUNT(*)"];

    }


    public function getSongIDs()
    {
        $songIDs = array();
        $query_text = "
                        SELECT id FROM songs  
                        WHERE album = :album_id 
                        ORDER BY id ASC
                      ";
        $query =  $this->db->prepare($query_text);
        $results = $query->execute(array(":album_id" => $this->id));
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push($songIDs, $row['id']);
        }
        
        return $songIDs;
       
    }
}
