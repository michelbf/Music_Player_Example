<?php

$playlistQuery = "SELECT id FROM songs ORDER BY RAND() LIMIT 3";
$playlist = $db->query($playlistQuery);

$playlistArray = array();
while ($song = $playlist->fetch(PDO::FETCH_ASSOC)) {
    array_push($playlistArray, $song['id']);
}

$jsonPlaylist = json_encode($playlistArray);

?>
 
<script>
    $(document).ready(function() {
            
        currentPlaylist = <?php echo $jsonPlaylist ?>;
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);
        
        $("#nowPlayingBar").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });
        
        $(".content.playbackContainer .progressBar").mousedown(function() {
            
           mouseDown = true; 
        });
        $(".content.playbackContainer .progressBar").mousemove(function(e) {
           if (mouseDown) {
               //set time of song depending on position of mouse
               timeBarOffset(e,this); 
           }
        });
        
        $(".content.playbackContainer .progressBar").mouseup(function(e) {
            timeBarOffset(e,this);
        });
        
        
        $(".volumeBar .progressBar").mousedown(function() {
            
           mouseDown = true; 
        });
        $(".volumeBar .progressBar").mousemove(function(e) {
           if (mouseDown) {
               var percentage = e.offsetX / $(this).width();
               audioElement.audio.volume = percentage;
               if (audioElement.audio.muted) {
                  muteSong();
               }
           }
        });
        
        $(".volumeBar .progressBar").mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
            audioElement.audio.volume = percentage;
            if (audioElement.audio.muted) {
                muteSong();
            }
        });
        
        
        $(document).mouseup(function() {
            mouseDown = false;
        })
        
    });
    
    function getRndInteger(min, max) {
        return Math.floor(Math.random() * (max - min + 1) ) + min;
    }
    
    function playRandomSong() {
        var randIndex = 0;
        var randMin = 0;
        var randMax = 0;

        randMin = 0;
        randMax = currentPlaylist.length - 1;
        while (randIndex == currentIndex) {
            randIndex = getRndInteger(randMin, randMax);
        }
        setTrack(currentPlaylist[randIndex], currentPlaylist, true);
    
    }
    
    function nextSong() {
        
        if (repeat) {
            audioElement.setTime(0);
            playSong();
            return;
        }
        
        if (shuffle) {
            
            playRandomSong();
            
            return;
        }
        
        if (currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
    
    function previousSong() {
        
        if (repeat) {
            audioElement.setTime(0);
            playSong();
            return;
        }
        
        if (shuffle) {
            
            playRandomSong();
            
            return;
        }
  
        if (audioElement.audio.currentTime >=3 ) {
            audioElement.setTime(0);
        } else {
        
            if (currentIndex == 0) {
                currentIndex = currentPlaylist.length - 1;
            } else {
                currentIndex--;
            }

            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);

        }
    }
    
    
    function timeBarOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        
        var seconds = audioElement.audio.duration * (percentage / 100);
    
        audioElement.setTime(seconds);
    }
    
    function setTrack(trackID, newPlaylist, play) {
        
        currentPlaylist = newPlaylist;
        
        currentIndex = currentPlaylist.indexOf(trackID);
        pauseSong();
        
        $.post("includes/handlers/ajax/getSongJson.php", { songID: trackID }, function(data) {
            
            
            
            data = JSON.parse(data);
            
            $(".artistName span").text(data.artist);
            $(".artistName span").attr("onclick", "openPage('artist.php?id=" + data.artistID + "', '.mainContent')");
            $(".trackName span").text(data.title);
            $(".trackName span").attr("onclick", "openPage('album.php?id=" + data.albumID + "', '.mainContent')");
            $(".albumArt").attr("src", data.artworkPath);
            $(".albumLink").attr("onclick", "openPage('album.php?id=" + data.albumID + "', '.mainContent')");
            
            
            audioElement.setTrack(data);
            if (play) {
                playSong();    
            }
            
        });
        
        
        
    }
    
    function playSong() {
        
        if(audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlayCount.php", { songID: audioElement.currentlyPlaying.id});
        }
        
        $('.controlButton.play').hide();
        $('.controlButton.pause').show();
        audioElement.play();
    }
    
    function pauseSong() {
        $('.controlButton.play').show();
        $('.controlButton.pause').hide();
        audioElement.pause();
    }
    
    function repeatToggle() {
        repeat = !repeat;
        console.log(repeat);
        if (repeat) {
            $(".controlButton.repeat").css("color", "rgb(30, 173, 30)");
        } else {
            $(".controlButton.repeat").css("color", "#d0d0d0");
        }
        
    }
    
    function muteSong() {
        audioElement.audio.muted = !audioElement.audio.muted ;
        
        if (audioElement.audio.muted) {
            $('.controlButton.volume').hide();
            $('.controlButton.mutedVolume').show();
            $(".volumeBar .progress").css("background-color","#d0d0d0");
            
        } else {
            $('.controlButton.volume').show();
            $('.controlButton.mutedVolume').hide();
            var volume = audioElement.audio.volume * 100;
            $(".volumeBar .progress").css("background-color","rgb(30, 173, 30)");
        }
        
        
    }
    
    function setShuffle() {
        shuffle = !shuffle;
        
        if (!shuffle) {
            $(".controlButton.shuffle").css("color","#d0d0d0");
            
        } else {
            $(".controlButton.shuffle").css("color","rgb(30, 173, 30)");
        }
    }

</script>
 
  
           
<div id="nowPlayingBar">
            
    <div id="nowPlayingLeft">
        <div class="content">
            <span class="albumLink customLink" role='link' tabindex=0>
                <img class="albumArt" src="http://via.placeholder.com/150x150" alt="Placeholder Image">
            </span>
            <span class="trackInfo">
                <span class="trackName">
                    <span role='link' tabindex=0 class='customLink'></span>
                </span>
                <span class="artistName">
                    <span role='link' tabindex=0 class='customLink'></span>
                </span> 
            </span>                   
        </div>
    </div>

    <div id="nowPlayingCenter">

       <div class="content playerControls">

           <div class="buttons">
              <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
                   <i class="ion-ios-shuffle-strong"></i>
               </button>
               <button class="controlButton back" title="Back" onclick="previousSong()">
                   <i class="ion-ios-skipbackward"></i>
               </button>
               <button class="controlButton play" title="Play" onclick="playSong()">
                   <i class="ion-ios-play"></i>
               </button>
               <button class="controlButton pause" title="Pause" onclick="pauseSong()">
                   <i class="ion-ios-pause"></i>
               </button>
               <button class="controlButton next" title="Next" onclick="nextSong()">
                   <i class="ion-ios-skipforward"></i>
               </button>
               <button class="controlButton repeat" title="Repeat" onclick="repeatToggle()">
                   <i class="ion-arrow-swap"></i>
               </button>
           </div>

       </div>

       <div class="content playbackContainer">
           <span class="playbackTime current">0.00</span>
           <div class="progressBar">
               <div class="progressBarBg">
                   <div class="progress"></div>
               </div>
           </div>
           <span class="playbackTime remaining">0.00</span>

       </div>

    </div>

    <div id="nowPlayingRight">
        <div class="volumeBar">
            <div class="volumeButton">
                <button class="controlButton volume" title="Volume" onclick="muteSong()">
                       <i class="ion-ios-volume-high"></i>
                </button>
                <button class="controlButton mutedVolume" title="Unmute" onclick="muteSong()">
                       <i class="ion-ios-volume-low"></i>
                </button>
            </div>
            <div class="progressBar">
               <div class="progressBarBg">
                   <div class="progress"></div>
               </div>
           </div>
        </div>
    </div>


</div>