  <?php
	 // this playlist executed as soon as page loads
	 $resultArray = array();
	 $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10"); 
	 while($row = mysqli_fetch_array($songQuery)){
        array_push($resultArray, $row['id']);
	 }
	 $jsonArray = json_encode($resultArray); 
	 ?>
	 <script> 
	   $(document).ready(function(){ // only executed when everythignis ready
		      
              var newPlaylist = <?php echo $jsonArray ?>;
			  audioElement =  new Audio();
			  setTrack(newPlaylist[0], newPlaylist, false);
			  updateVolumeProgressBar(audioElement.audio);
             
			  $('#nowPlayingBarContainer').on("mousedown touchstart mousemove touchmove", function(e){
                     e.preventDefault(); // prevents the default behaviour for that event
			  });

			  $(".playbackBar .progressBar").mousedown(function(){
				  mouseDown = true; 
			  })
			  $(".playbackBar .progressBar").mousemove(function(e){
				  if (mouseDown){
					  // set time of song depending on the position of mouse
                      timeFromOffset(e, this); // this is the progressBar
				  }
			  })
			  $(".playbackBar .progressBar").mouseup(function(e){
                      timeFromOffset(e, this); // this is the progressBar
			  })
			  $(".volumeBar .progressBar").mousedown(function(){
				  mouseDown = true;
			  })
			  $(".volumeBar .progressBar").mousemove(function(e){
				  if (mouseDown){
					  // set time of song depending on the position of mouse
                      var percentage = e.offsetX / $(this).width();
					  audioElement.audio.volume = percentage; 
					//  $(".volumeBar .progress").css("width", percentage*100 + "%");
				  }
			  })
			  $(".volumeBar .progressBar").mouseup(function(e){
                      var percentage = e.offsetX / $(this).width();
					  audioElement.audio.volume = percentage; 
					//  $(".volumeBar .progress").css("width", percentage*100 + "%");
			  })
	          
			  $(document).mouseup(function(){
				  mouseDown  =  false;
			  })
	   });
	   function timeFromOffset(mouse, progressBar){
            var percentage = mouse.offsetX / $(progressBar).width() * 100;
			var seconds = audioElement.audio.duration * percentage/100;
			audioElement.setTime(seconds);
	   }
	   function nextSong(){
		   console.log(currentIndex);
		   if (repeat == true){
			   audioElement.setTime(0);
			   playSong();
			   return;
		   }
		   if (currentIndex == currentPlaylist.length-1){
			  
		      currentIndex = 0;
			//  setTrack(currentIndex, currentPlaylist, true);
		   } else{
			   currentIndex ++;
		   }
		   var tracktoPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		   setTrack(tracktoPlay, currentPlaylist, true);
		   console.log(currentIndex);
	   } 
	   function prevSong(){
		   if (audioElement.audio.currentTime >= 3 || currentIndex == 0){
                audioElement.setTime(0);
		   } else{
			   currentIndex = currentIndex - 1; // only index ..  we need id
			   var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
			   setTrack(trackToPlay, currentPlaylist, true);
		   }
	   }
	   function setRepeat(){
		   repeat = !repeat;
		   var Imagename = repeat ? "repeat-active.png" : "repeat.png";
		   $('.controlButton.repeat img').attr("src", "assets/icons/"+Imagename);
	   }
	   function setMute(){
		   audioElement.audio.muted = ! audioElement.audio.muted;
		   var Imagename = audioElement.audio.muted ? "mute.png" : "volume.png";
		   $('.controlButton.volume img').attr("src", "assets/icons/"+Imagename);
	   }
	   function setShuffle(){
		   shuffle = !shuffle;
		   var Imagename = shuffle ? "shuffle-active.png" : "shuffle.png";
		   $('.controlButton.shuffle img').attr("src", "assets/icons/"+Imagename);
		   if (shuffle){
			   // randomize playlist
			   shuffleArray(shufflePlaylist); 
			   currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
			
		   } else{
			   // shuffle activated so go back to regular playlist
			   currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		   }
	   }
	   function shuffleArray(a){
          var j,x,i;
          for (i = a.length; i; i--){
              j = Math.floor(Math.random() * i);
              x = a[i-1];
              a[i-1] = a[j];
              a[j] = x;
          }
           return a;
       }
	   function setTrack(trackId, newPlaylist, play){
		     if (newPlaylist != currentPlaylist){
				 currentPlaylist = newPlaylist;
				 shufflePlaylist = currentPlaylist.slice(); // returns a copy
				 shuffleArray(shufflePlaylist);
			 }
			 if (shuffle == true){ 
                currentIndex = shufflePlaylist.indexOf(trackId);
			 } else{
                currentIndex = currentPlaylist.indexOf(trackId);
			 } 

			 $.post("includes/handlers/ajax/getSongJSON.php", {songId: trackId},function(data){
				
		        var track = JSON.parse(data);
                audioElement.setTrack(track);
				$(".trackName span").text(track.title);
				$(".trackName span").attr("onclick", "openPage('album.php?id=" + track.album + "')");


			    $.post("includes/handlers/ajax/getArtistJSON.php", {artistId: track.artist}, function(data){
                   var artist = JSON.parse(data);
				   $(".trackInfo .artistName span").text(artist.name);
				   $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");

				});
				$.post("includes/handlers/ajax/getAlbumJSON.php", {albumId: track.album}, function(data){
                   var album = JSON.parse(data);
				   $(".content .albumLink img").attr("src",album.artPath);
				   $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				});
				if (play == true){
                   playSong();
			    } 
			 });
		     
	   }		
	   function playSong(){
		   if (audioElement.audio.currentTime == 0){
			
               $.post("includes/handlers/ajax/updatePlaysJSON.php", { songId: audioElement.currentlyPlaying.id});
		   }
		   $(".controlButton.play").hide();
		   $('.controlButton.pause').show();
		   audioElement.play();
	   } 
	   function pauseSong(){
		   $(".controlButton.play").show();
		   $('.controlButton.pause').hide();
		   audioElement.pause();
	   }
	 </script>




<div id="nowPlayingBarContainer">

			<div id="nowPlayingBar">

				<div id="nowPlayingLeft">
					<div class="content">
						<span class="albumLink">
						  <img src="assets/images/artwork/background.jpg" role="link" tabindex="0" class="albumArt">
						</span>
						<div class="trackInfo">
							<span class="trackName"> 
							  <span style="color:white" role="link" tabindex="0"> </span>
							</span>
							<span class="artistName"> 
							  <span role="link" tabindex="0"> </span>
							</span>
						</div>


					</div>
					
				</div>

				<div id="nowPlayingCenter">

					<div class="content playerControls">

						<div class="buttons">
							<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
								<img src="assets/icons/shuffle.png" alt="Shuffle">
							</button>
							<button class="controlButton previous" title="Previous button" onclick="prevSong()">
								<img src="assets/icons/rewind.png" alt="Previous">
							</button>
							<button class="controlButton play" title="Play button" onclick="playSong()">
								<img src="assets/icons/play.png" alt="Play">
							</button>
							<button class="controlButton pause" title="Pause button" style="display: none" onclick="pauseSong()">
								<img src="assets/icons/pause.png" alt="pause">
							</button>
							<button class="controlButton next" title="Next button" onclick="nextSong()" >
								<img src="assets/icons/forwind.png" alt="Next">
							</button>
							<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
								<img src="assets/icons/repeat.png" alt="Repeat">
							</button>
						</div>
						<div class="playbackBar">
							<span class="progressTime current">0.00</span>
							<div class="progressBar">
								<div class="progressBarBg">
									<div class="progress"></div>
								</div>
							</div>
							<span class="progressTime remaining">0.00</span>
					    </div>
				</div>
				
			</div>
			<div id="nowPlayingRight">
					<div class="volumeBar">
						<button class="controlButton volume" title="volume" onclick="setMute()">
					      <img src="assets/icons/volume.png"> 
						</button>
						<div class="progressBar">
								<div class="progressBarBg">
									<div class="progress"></div>
								</div>
					    </div>
					</div>		

					</div>
			</div>

		</div>