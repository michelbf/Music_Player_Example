var currentPlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var repeat = false;
var shuffle = false;
var currentIndex = 0;
var userLoggedIn;
var timer = null;
    

function createPlaylist() {
    
    let popup = prompt("Please insert new playlist name: ");
    
    if (popup != null) {
        $.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn }).done(function(msg){
            if (msg != null) {
                alert(msg);
                openPage("yourMusic.php");
            }
            
            openPage("yourMusic.php");
        });
    }
    
}

function deletePlaylist(playlistID) {
    let popup = confirm("Are you sure you want to delete this playlist?");
    if (popup) {
        $.post("includes/handlers/ajax/deletePlaylist.php", { playlistID: playlistID }).done(function(msg){
            if (msg != null) {
                alert(msg);
                openPage("yourMusic.php");
            }
            
            openPage("yourMusic.php");
        });
    }
}


function play(song_id, tempPlaylist) {
    
    setTrack(song_id, tempPlaylist, true);
}

function openPage(url){
    
    if (timer != null) {
        clearTimeout(timer);
        console.log("cleared timer");
    } 
    
    if(url.indexOf("?") == -1) {
        url = url + "?";
        
    } else {
        url = url + "&";
        
    }
    
    var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    
    $('.mainContent').load(encodedURL) ;
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}


function formatTime(time) {
    minutes= Math.floor(time/60);
    seconds= Math.round(time % 60);
    
    if (seconds < 10) {
        extraZero = "0";
    } else {
        extraZero = "";
    }
    
    fulltime = minutes + ":" + extraZero + seconds;
    return fulltime;
}

function updateTimeProgressBar(audio) {
    $(".playbackTime.current").text(formatTime(audio.currentTime));
    $(".playbackTime.remaining").text(formatTime(audio.duration - audio.currentTime));
    
    var progress = audio.currentTime / audio.duration *100;
    $(".content.playbackContainer .progress").css("width",progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width",volume + "%");    
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');
    
    this.audio.addEventListener("ended", function() {
       nextSong(); 
    });
    
    this.audio.addEventListener("canplay", function() {
       $(".playbackTime.remaining").text(formatTime(this.duration)); 
    });
    
    this.audio.addEventListener("timeupdate", function() {
        
       if (this.duration) {
           updateTimeProgressBar(this);
       } 
    });
    
    this.audio.addEventListener("volumechange", function() {
       updateVolumeProgressBar(this); 
    });
    
    this.setTrack = function(data) {
        this.currentlyPlaying = data;
        this.audio.src = data.path;
    }
    
    this.play = function() {
        this.audio.play();
    }
    
    this.pause = function() {
        this.audio.pause();
    }
    
    this.setTime = function(seconds) {
    
        this.audio.currentTime = seconds; 
    }
    
    
}