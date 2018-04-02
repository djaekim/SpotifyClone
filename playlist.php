<?php
 include("includes/includedFiles.php");

 

 $albumId;
 if (isset($_GET['id'])){
    $playlistId = $_GET['id'];
 } else {
     header ("Location: index.php");
 } 
 $playlist = new Playlist($con, $playlistId);
 $owner = new User($con, $playlist->getOwner());

?>
 <div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/icons/playlist.png">
        </div>
       
    </div>
    <div class="rightSection">
        <h2> <?php echo $playlist->getName() ?> </h2>
        <p> <?php echo $playlist->getOwner() ?> </p>
        <p> <?php echo $playlist->getNumbSongs(). " songs"?> </p>
        <button class="button" onclick='deletePlaylist("<?php echo $playlistId ?>")'> DELETE PLAYLIST </button>
    </div>
 </div>
 <div class="trackListContainer">
   <ul class="tracklist">
       <?php 
         $songIdArray = $playlist->getSongIds();
         $i = 0;
         foreach ($songIdArray as $getSongId){
             $playlistSong = new Song($con, $getSongId);
             $playlistArtist = $playlistSong->getArtist();
             
         
             echo "
                <li class='tracklistRow'>
                   <div class='trackCount'>
                       <img class='play' src='assets/icons/play-black.png' onclick='setTrack(\"".$playlistSong->getId()."\", albumPlaylist, true)'> 
                       <span class='trackNumber'> $i </span>
                   </div>

                   <div class='trackInfo'>
                     <span class='trackName'>".
                       $playlistSong->getTitle() ." 
                     </span>
                     <span class='artistName'>".
                       $playlistArtist->getName() ."
                     </span>
                   </div>
                    <div class='trackOptions'>
                      <input type='hidden' class='songId' value='".$playlistSong ->getId()."'>
                      <img class='optionsButtons' src='assets/icons/more.png' onclick='showOptionsMenu(this)'> 
                   </div>
                   <div class='trackDuration'>
                       <span class='duration'>".$playlistSong->getDuration() ."</span>
                   </div>
                </li>
             ";
             $i++;
         }
       ?>
       <script>
         var playlistSongIds = '<?php echo json_encode($songIdArray); ?>';
         albumPlaylist = JSON.parse(playlistSongIds);

       </script>
     
   </ul>
 </div>
  <nav class='optionsMenu'>
     <input type='hidden' class='songId'> <!-- static variable  is  :: -->
     <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()) ?>
     <div class='items' onclick='removeFromPlaylist(this,"<?php echo $playlistId ?>");'> Remove from Playlist</div>
 </nav>
 <?php

?>