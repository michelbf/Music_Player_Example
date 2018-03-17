<?php 
include("includes/includedFiles.php");

?>

    
    

    <h1>You Might Also Like</h1>
    <?php 
        $albums = $db->query("SELECT * FROM albums ORDER BY Rand() LIMIT 10");
        while($album = $albums->fetch(PDO::FETCH_ASSOC)) {

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
