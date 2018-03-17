<?php 

include("includes/includedFiles.php");
require_once("includes/classes/Song.php");
require_once("includes/classes/Artist.php");
use Slotify\Song;
use Slotify\Artist;

?>


    
<?php 
    
if (isset($_GET['id']))
{
    $artistID = $_GET['id'];
    $artist = new Artist($db, $artistID);
   
} else {
    header("Location: index.php");
}
    
?>


<script>

$(document).ready(function(){
   $(".headerButtons").on("mousedown touchstart mousemove touchmove", function(e) {
       e.preventDefault();
   });
});
    

</script>



<div class="entityInfo bottomBorder">
    <div class="centerSection">
        <div class="artistInfo">
            <h1><?php echo $artist->getName() ?></h1>
            <div class="headerButtons">
                <button class="button" onclick="setTrack(tempPlaylist[0],tempPlaylist,true)">PLAY</button>
            </div>
        </div>
        
    </div>
    
</div>

<div class="trackListContainer bottomBorder">
   <h2 class='artistInfoTitle'>SONGS</h2>
    <ul class="trackList">
        <?php 
        $songIDs = $artist->getSongIDs();

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


<script>
    var songIDs = "<?php echo json_encode($songIDs) ?>";
    tempPlaylist = JSON.parse(songIDs); 
</script>

<?php 
        $query = $db->prepare("SELECT * FROM albums WHERE artist = :artistID");
        $query->execute(array(":artistID" => $artistID));
    
        while($album = $query->fetch(PDO::FETCH_ASSOC)) {

            $albumTitle = $album['title'];
            $albumArtwork = $album['artworkPath'];
            $albumID = $album['id'];

            echo "
            <h2 class='artistInfoTitle'>ALBUMS</h2>
            <div class='displayItem'> 
                <span onclick=\"openPage('album.php?id=$albumID', '.mainContent')\" role='link' tabindex=0 class='customLink'>
                <img src='$albumArtwork'>
                <div class='displayItemInfo'>
                $albumTitle
                </div>
                </span>
            </div>
            ";

        }

    

?>



