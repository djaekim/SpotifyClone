<?php
 include("includes/includedFiles.php");
 /*
 our artist page takes artist id in the url
 */
  if (isset($_GET['id'])){ // if id has been provided in the url we take it
    $artistId = $_GET['id'];
  } else {
     header ("Location: index.php");
  } 

  $artist = new Artist($con, $artistId);
?>
  <div class="entityInfo borderBottom">
   <div class="centerSection">
    <div class="artistInfo">
     <h1 class="artistName" style="text-align:center"><?php echo $artist->getName() ?></h1>
     <div class="headerbuttons">
      <button class="button red" onclick="playFirstSong()"> PLAY </button>
     </div>
    </div>
   </div>
  </div>
  <div class="trackListContainer borderBottom">
   <ul class="tracklist">
     <h2> Songs </h2>
       <?php 
         $songIdArray = $artist->getSongIds();
         $i = 0;
         foreach ($songIdArray as $getSongId){
             
             $Albumsong = new Song($con, $getSongId);
             $albumArtist = $Albumsong->getArtist();
             
         
             echo "
                <li class='tracklistRow'>
                   <div class='trackCount'>
                       <img class='play' src='assets/icons/play-black.png' onclick='setTrack(\"".$Albumsong->getId()."\", albumPlaylist, true)'> 
                       <span class='trackNumber'> $i </span>
                   </div>

                   <div class='trackInfo'>
                     <span class='trackName'>".
                       $Albumsong->getTitle() ." 
                     </span>
                     <span class='artistName'>".
                       $albumArtist->getName() ."
                     </span>
                   </div>
                    <div class='trackOptions'>
                      <input type='hidden' class='songId' value='".$Albumsong ->getId()."'>
                      <img class='optionsButtons' src='assets/icons/more.png' onclick='showOptionsMenu(this)'> 
                   </div>
                   <div class='trackDuration'>
                       <span class='duration'>".$Albumsong->getDuration() ."</span>
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
 <div class="gridViewContainer"> 
   <h2> Albums </h2>
				 <?php 
				    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'" );
					while($row = mysqli_fetch_array($albumQuery)){
						echo "
						 <div class='gridViewItem'>
						   <span onclick='openPage(\"album.php?id=".$row['id']."\")'>
						   <img src='".$row['artPath']."'>

						   <div class='gridViewInfo'>
                              ".$row['title']."
						   </div>
						   </span>
						 </div>";
					} 
				 ?>
			  </div> 