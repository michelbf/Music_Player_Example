<?php 
require_once("../../config.php");


if (isset($_POST['playlistID'])) {
    
    $playlistID = $_POST['playlistID'];
    
    $query = $db->prepare("DELETE FROM playlistsongs WHERE playlistId = :playlist_id ");
    $query->execute(array(":playlist_id" => $playlistID));
    
    $query = $db->prepare("DELETE FROM playlists WHERE id = :playlist_id ");
    $query->execute(array(":playlist_id" => $playlistID));
    
    echo "Deleted.";
} else {
    echo "Error";
}