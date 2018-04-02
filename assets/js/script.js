var currentPlaylist = [];
var shufflePlaylist = [];
var albumPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;
$(document).click(function(click){
   var target = $(click.target);
   if (!target.hasClass("items") && !target.hasClass("optionsButtons")){ // if we haven't clicked on items class
          hideOptionsMenu();
   }
});
    
$(window).scroll(function(){
 hideOptionsMenu();
});
// .on ( evnt, target, do foollow)
// this is element which event was fired on
$(document).on("change","select.playlist", function(){
    var select = (this);
    var playlistId = $(select).val();
    var songId = $(select).prev(".songId").val();
    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId}).done(function(error){
        if (error != ""){
            alert(error);
            return;
        }
        hideOptionsMenu();
        $(select).val(""); // this inside refers to call back
        

    });
}); // select with item playlist
function logout(){
    $.post("includes/handlers/ajax/logout.php", function(e){
        location.reload(); // ??
    });
}
function deletePlaylist(playlistId){
    var prompt = confirm("Are you sure you want to delete this playlist");

    if (prompt == true){
         // execute an insert using ajax
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId }).done(function(e){
          if (e != ""){ 
              alert(e);
              return;
          }
          // done is preferred way to handle ajax responses due to deferreds...
          // go from js to mysqli - use ajax
          // but here you are only inserting to data base but not getting any response from ajax
          // after you insert we want to open the search page with the new playlist
          openPage("yourMusic.php"); // page refresh ..  with newly added
          // in the openPage - this is where we want to output playlist
        }); 
    }

} 
function removeFromPlaylist(button, playlistId){ //element = options menu
    var songId = $(button).prevAll(".songId").val(); 
    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId}).done(function(e){
          if (e != ""){ 
              alert(e);
              return;
          }
          // done is preferred way to handle ajax responses due to deferreds...
          // go from js to mysqli - use ajax
          // but here you are only inserting to data base but not getting any response from ajax
          // after you insert we want to open the search page with the new playlist
          openPage("playlist.php?id=" + playlistId); // page refresh ..  with newly added
          // in the openPage - this is where we want to output playlist
    }); 
}
function hideOptionsMenu(){
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none"){
        menu.css("display", "none");
    }
}
function showOptionsMenu(button){
    var songId = $(button).prevAll(".songId").val(); // from button go to prev song id
    
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);
    var scrollTop = $(window).scrollTop(); 

    var  elementOffset = $(button).offset().top; //position of element from top of the document

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({"top": top + "px", "left": left-menuWidth+"px", "display": "inline"});
     
}
function createPlaylist(){
    var popup = prompt("please enter the name of the playlist");
    if (popup != null){
        // execute an insert using ajax
        $.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn,}).done(function(e){
          if (e != ""){ 
              alert(e);
              return;
          }
          // done is preferred way to handle ajax responses due to deferreds...
          // go from js to mysqli - use ajax
          // but here you are only inserting to data base but not getting any response from ajax
          // after you insert we want to open the search page with the new playlist
          openPage("yourMusic.php"); // page refresh ..  with newly added
          // in the openPage - this is where we want to output playlist
        }); 
    }
}
function playFirstSong(){
    setTrack(albumPlaylist[0], albumPlaylist, true);
}
function formatTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = Math.round(time - minutes*60);
    var extraZero;
    if (seconds < 10){
        extraZero = "0";
    } else{
        extraZero ="";
    }
    return minutes + ":" + extraZero + seconds;
}
function updateTimeProgressBar(audio){
      $(".progressTime.current").text(formatTime(audio.currentTime)); 
      $(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));
      var progress = audio.currentTime / audio.duration * 100;
      $(".playbackBar .progress").css("width", progress +"%");
}
function updateVolumeProgressBar(audio){
      var volume = audio.volume * 100;
      $(".volumeBar .progress").css("width", volume +"%");
}
function updateEmail(emailClass){
    var email_value = $('.' + emailClass).val();
   
    // we call these function from userDetail page
    // we are getting this input value from email class tag..

    $.post("includes/handlers/ajax/updateEmail.php", {email:email_value, username: userLoggedIn}).done(function(response){
       $('.' + emailClass).nextAll('.message').text(response);
       //where email input is go and get the next class with nae message and put response
      // nextall gets the siblings - all of the siblings ... elements in the same level without going into each divs
       
    });
}
function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2){
    var oldPassword = $('.' + oldPasswordClass).val();
    var newPassword1 = $('.' + newPasswordClass1).val();
    var newPassword2 = $('.' + newPasswordClass2).val();
   
    // we call these function from userDetail page
    // we are getting this input value from email class tag..

    $.post("includes/handlers/ajax/updatePassword.php", {username: userLoggedIn, oldpassword: oldPassword, newpassword1: newPassword1, newpassword2: newPassword2}).done(function(response){
       $('.' + oldPasswordClass).nextAll('.message').text(response);
       //where email input is go and get the next class with nae message and put response
      // nextall gets the siblings - all of the siblings ... elements in the same level without going into each divs
       
    });
}
function openPage(url){
    if( timer != null){
        clearTimeout(timer);
    }
    if (url.indexOf("?") == -1){
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
   // console.log(encodedUrl);
    $("#mainContent").load(encodedUrl);
    $('body').scrollTop(0);
    history.pushState(null, null, url);

}
function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio'); 
   
    this.audio.addEventListener("canplay", function(){
        $(".progressTime.remaining").text(formatTime(this.duration));
         
    });
    this.audio.addEventListener("timeupdate", function(){
        if (this.duration){
            updateTimeProgressBar(this); // this is this Audio object
        }
    });
    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });
    this.audio.addEventListener("ended", function(){
        nextSong();
    });

    this.setTrack = function(track){
        this.currentlyPlaying = track;
        this.audio.src = track.path; // audio elemnt 
    }
    this.play = function(){
        this.audio.play();
    }
    this.pause = function(){
        this.audio.pause();
    }
    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }

    
    
}