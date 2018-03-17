<?php 

include("includes/includedFiles.php");
require_once("includes/classes/Album.php");
require_once("includes/classes/Song.php");
use Slotify\Album;
use Slotify\Song;

?>


    
<?php 
    
if (isset($_GET['id']))
{
    $albumID = $_GET['id'];
    $album = new Album($db, $albumID);
    $songIDs = json_encode($album->getSongIDs());
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
        <img src="<?php echo $album->getArtworkPath() ?>" alt="Artwork">        
    </div>
    
    <div class="rightInfo">
        <h2><?php echo $album->getTitle() ?></h2>
        <span><?php echo $album->getArtist() ?></span><br>
        <span><?php echo $album->getNumberofSongs() . " Song(s)"?></span>        
    </div>
    
</div>

<div class="trackListContainer">
    <ul class="trackList">
        <?php 
        $songIDs = $album->getSongIDs();

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
