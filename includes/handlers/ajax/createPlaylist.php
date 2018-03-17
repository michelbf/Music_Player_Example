<?php 
require_once("../../config.php");
require_once("../../classes/Song.php");

use Slotify\Song;

if (isset($_POST['username']) && isset($_POST['name'])) {
    
    $playlistName = $_POST['name'];
    $playlistUser = $_POST['username'];
    
    $query = $db->prepare("INSERT INTO playlists (name, user, dateCreated) VALUES (:name, :user, now()) ");
    if($query->execute(array(":name" => $playlistName, ":user" => $playlistUser))) {
        echo "Created Successfully!";
    } else {
        echo "Error";
    }
    
} else {
    echo "Error";
}