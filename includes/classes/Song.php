<?php
namespace Slotify;

use PDO;

class Song
{

    private $db;

    private $id;
    private $title;
    private $artist;
    private $artistID;
    private $album;
    private $albumID;
    private $genre;
    private $path;
    private $duration;
    private $albumOrder;
    private $songData;
    private $artworkPath;

    public function __construct($db, $id)
    {
        $this->db = $db;
        $this->id = $id;

        $query_text = "
                       SELECT songs.artist as artistID, songs.id as id, songs.title as title, songs.path as path, songs.albumOrder as albumOrder,  
                              artists.name as artist, genres.name as genre, songs.duration as duration, 
                              albums.title as album, songs.album as albumID, albums.artworkPath   
                       FROM albums, artists, genres, songs  
                       WHERE songs.id = :song_id 
                       AND songs.artist = artists.id 
                       AND songs.genre = genres.id 
                       AND songs.album = albums.id
                       ";

        $query = $this->db->prepare($query_text);
        $result = $query->execute(array(':song_id' => $this->id));
        
        

        $song = $query->fetch();
        
        $this->songData = $song;
        
        $this->title = $song['title'];
        $this->artist = $song['artist'];
        $this->genre = $song['genre'];
        $this->album = $song['album'];
        $this->albumID = $song['albumID'];
        $this->duration= $song['duration'];
        $this->path = $song['path'];
        $this->albumOrder = $song['albumOrder'];
        $this->artworkPath = $song['artworkPath'];
        $this->artistID = $song['artistID'];
        
        

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

    public function getAlbum()
    {
        return $this->album;
    }

    public function getDuration()
    {
        return $this->duration;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getSongData()
    {
        return $this->songData;
    }
    
    public function getArtwork()
    {
        return $this->artworkPath;
    }
    
    public function updatePlayCount() 
    {
        $query_text = "UPDATE songs SET plays = plays+1 WHERE id = :songID";
        $query = $this->db->prepare($query_text);
        $query->execute(array(':songID' => $this->id));
        
    }

}
