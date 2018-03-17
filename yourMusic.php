<?php 
include("includes/includedFiles.php"); 
include("includes/classes/Playlist.php"); 
use Slotify\Playlist;

?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="headerButtons">
            <button class="button" onclick="createPlaylist()">NEW PLAYLIST</button>
        </div>
        
    </div>
</div>

 <?php 
    
        $query = $db->prepare("SELECT * FROM playlists WHERE user = :username");
        $query->execute(array(":username" => $userLoggedIn->getUsername()));
    
        while($playlistData = $query->fetch(PDO::FETCH_ASSOC)) {

            $playlist = new Playlist($db, $playlistData);
            $playlistID = $playlist->getId();
   
            echo "
            <div class='displayItem'> 
                <div class='playlistDisplay'>
                    <span onclick='openPage(\"playlist.php?id=$playlistID\")' role='link' tabindex=0 class='customLink navItemLink'>
                        <i class='ion-music-note'></i>
                        <div class='displayItemInfo'>
                            " . $playlist->getName() . "
                        </div>
                    </span>
                </div>
            </div>
            ";

        }

    

?>

