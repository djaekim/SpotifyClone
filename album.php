<?php
 include("includes/includedFiles.php");

 

 $albumId;
 if (isset($_GET['id'])){
    $albumId = $_GET['id'];
 } else {
     header ("Location: index.php");
 } 
 $album = new Album($con, $albumId);
 $artist = $album->getArtist();
?>
 <div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtPath(); ?>">
    </div>
    <div class="rightSection">
        <h2> <?php echo $album->getTitle() ?> </h2>
        <p> <?php echo $artist->getName() ?> </p>
        <p> <?php echo $album->getNumbSongs(). " songs"?> </p>
    </div>
 </div>
 <div class="trackListContainer">
   <ul class="tracklist">
       <?php 
         $songIdArray = $album->getSongIds();
         $i = 0;
         foreach ($songIdArray as $getSongId){
             $albumSong = new Song($con, $getSongId);
             $albumArtist = $albumSong->getArtist();
             
         
             echo "
                <li class='tracklistRow'>
                   <div class='trackCount'>
                       <img class='play' src='assets/icons/play-black.png' onclick='setTrack(\"".$albumSong->getId()."\", albumPlaylist, true)'> 
                       <span class='trackNumber'> $i </span>
                   </div>

                   <div class='trackInfo'>
                     <span class='trackName'>".
                       $albumSong->getTitle() ." 
                     </span>
                     <span class='artistName'>".
                       $albumArtist->getName() ."
                     </span>
                   </div>
                   <div class='trackOptions'>
                      <input type='hidden' class='songId' value='".$albumSong ->getId()."'>
                      <img class='optionsButtons' src='assets/icons/more.png' onclick='showOptionsMenu(this)'> 
                   </div>
                   <div class='trackDuration'>
                       <span class='duration'>".$albumSong->getDuration() ."</span>
                   </div>
                </li>
             ";
             $i++;
         }
       ?>
       <script>
         var albumSongIds = '<?php echo json_encode($songIdArray); ?>';
         albumPlaylist = JSON.parse(albumSongIds);

       </script>
     
   </ul>
 </div>
 <nav class='optionsMenu'>
     <input type='hidden' class='songId'> <!-- static variable  is  :: -->
     <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
    
 </nav>

 <?php

?>