<?php 

include("includes/includedFiles.php");
require_once("includes/classes/Album.php");
require_once("includes/classes/Song.php");
require_once("includes/classes/Playlist.php");
use Slotify\Album;
use Slotify\Song;
use Slotify\Playlist;

?>


    
<?php 
    
if (isset($_GET['id']))
{
    $playlistID = $_GET['id'];
    $playlist = new Playlist($db, $playlistID);
    $songIDs = json_encode($playlist->getSongIDs());
} else {
    header("Location: index.php");
}
    
?>

<script>

$(document).ready(function(){
   tempPlaylist = JSON.parse('<?php echo $songIDs; ?>'); 
});
    

</script>


<div class="entityInfo">
    <div class="leftInfo">
        <i class='ion-music-note'></i>      
    </div>
    
    <div class="rightInfo">
        <h2><?php echo $playlist->getName() ?></h2>
        <span><?php echo $playlist->getNumberofSongs() . " Song(s)"?></span>    
        <div class="headerButtonsLeft">
            <?php echo "<button class='buttonTransparent' onclick=\"deletePlaylist($playlistID)\">DELETE PLAYLIST</button>"; ?>
        </div>    
    </div>
    
</div>

<div class="trackListContainer">
    <ul class="trackList">
        <?php 
        $songIDs = $playlist->getSongIDs();

        $i = 1;
        foreach($songIDs as $songID) {
            
            $albumSong = new Song($db, $songID);
            $songArtist = $albumSong->getArtist();
            $songName = $albumSong->getTitle();
            $songDuration = $albumSong->getDuration();
            
            echo "<li class='tracklistRow'>
                    <div class='trackCount'  onclick=\"play({$songID}, tempPlaylist)\">
                        <span class='trackNumber'>{$i}</span>
                        <i class='ion-ios-play'></i>
                    </div>
                    
                    <div class='trackInfo'>
                        <span class='trackTitle'>{$songName}</span>
                        <span class='trackArtist'>{$songArtist}</span>
                    </div>
                    
                    <div class='trackOptions'>
                        <i class='ion-android-more-horizontal'></i>
                    </div>
                    
                    <div class='trackDuration'>
                        <span class='duration'>{$songDuration}</span>
                    </div>
                    
                </li>";
            
            $i++;
        }

        ?>
    </ul>
</div>
