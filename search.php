<?php 
include("includes/includedFiles.php"); 
require_once("includes/classes/Album.php");
require_once("includes/classes/Song.php");
use Slotify\Album;
use Slotify\Song;

?>


<?php 
if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}
?>

<div class="searchContainer">
    <h4>Search for an album, artist or song. </h4>
    <input type="text" id="search" class="searchInput" value='<?php echo $term ?>' placeholder="Start Typing..." onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
</div>

<script>
   
    $(".searchInput").focus();
    $(function() {
        
        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            
            timer = setTimeout(function(){
                var val =  $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 500);
        });
        
    });    
</script>


<div class="trackListContainer bottomBorder">
   <h2 class='artistInfoTitle'>SONGS</h2>
    <ul class="trackList">
        <?php 
        
        $query = $db->prepare("SELECT * FROM songs WHERE title LIKE :term");
        
        $query->execute(array(":term" => "%" . $term . "%"));
           
          
        $i = 1;
        while($song = $query->fetch(PDO::FETCH_ASSOC))  {

            $songID = $song['id'];
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





<div class="bottomBorder">
    <h2 class='artistInfoTitle'>ALBUMS</h2>
 <?php 
        $query = $db->prepare("SELECT * FROM albums WHERE title LIKE :term");
        $query->execute(array(":term" => "%" . $term . "%"));
    
        while($album = $query->fetch(PDO::FETCH_ASSOC)) {

            $albumTitle = $album['title'];
            $albumArtwork = $album['artworkPath'];
            $albumID = $album['id'];

            echo "
            <div class='displayItem'> 
                <span onclick=\"openPage('album.php?id=$albumID')\" role='link' tabindex=0 class='customLink'>
                <img src='$albumArtwork'>
                <div class='displayItemInfo'>
                $albumTitle
                </div>
                </span>
            </div>
            ";

        }

    

    ?>
</div>




<div class="artistContainer">
   <h2 class='artistInfoTitle'>ARTISTS</h2>
        <?php 
        
        $query = $db->prepare("SELECT * FROM artists WHERE name LIKE :term");
        
        $query->execute(array(":term" => "%" . $term . "%"));
           
          
        $i = 1;
        while($artist = $query->fetch(PDO::FETCH_ASSOC))  {

            $artistID = $artist['id'];
            $artistName = $artist['name'];

            
            echo "<span onclick=\"openPage('artist.php?id=$artistID')\" role='link' tabindex=0 class='artistLink'>
                    <div class='artistNameResult'>
                          {$artistName}      
                    </div>
                </span> ";
            
            $i++;
        }

        ?>
</div>