<?php 
require_once("../../config.php");
require_once("../../classes/Song.php");

use Slotify\Song;

if (isset($_POST['songID'])) {
    $songID = $_POST['songID'];
    $song = new Song($db, $songID);
    $song->updatePlayCount();
    console.log("update");
}
        