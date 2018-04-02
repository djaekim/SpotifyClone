<?php
 include("includes/includedFiles.php");
 if (isset($_GET['term'])){
     $term = $_GET['term'];
     $term = urldecode($term);
 } else{
     $term = "";
 }

?>

<div class="searchContainer">
  <h4> Search for an artist, album or song </h4>
  <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="start typing" onfocus="var val=this.value; this.value=''; this.value= val;"> 
</div>
<script>
  $(".searchInput").focus();
  $(function(){
   
    $(".searchInput").keyup(function(){
        clearTimeout(timer);
        timer = setTimeout(function(){
           var val = $(".searchInput").val();
           openPage("search.php?term=" +val);
           console.log("hi");
        }, 2000);
    });
  });
</script>
<?php  if ($term == "") exit() // if esarch term is empty we don't do anythig at the bottom of the page ?> 

<div class="trackListContainer borderBottom">
   <ul class="tracklist">
     <h2> SONGS </h2>
       <?php 
         $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%'");
         if (mysqli_num_rows($songsQuery) == 0){
             echo ("<span class='noResults'> No Songs found matching ". $term. "<span>");
         }
         $songIdArray = array();
         $i = 0;
         while ($row = mysqli_fetch_array($songsQuery)){
             if ($i >15){
                 break;
             }
             
             array_push($songIdArray, $row['id']);
             $Albumsong = new Song($con, $row['id']);
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
 <div class="artistsContainer borderBottom">
     <h2> ARTISTS </h2>
     <?php
     $artistsQuery = mysqli_query($con, "SELECT id FROM artist WHERE name LIKE '$term%'");
     if (mysqli_num_rows($artistsQuery) == 0){
             echo ("<span class='noResults'> No Artists found matching ". $term. "<span>");
     }
     while($row = mysqli_fetch_array($artistsQuery)){
         $artistFound = new Artist($con, $row['id']);
         echo "<div class='searchResultRow'> 
           <div class='artistName'>
             <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=".$artistFound->getId()."\")'>
                "
                 . $artistFound->getName().
                "
             </span>
           
           
           </div>
         </div>";

     }
     ?>


 </div>
 </div>
 <div class="gridViewContainer"> 
   <h2> Albums </h2>
				 <?php 
				    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE'$term%'" );
					if (mysqli_num_rows($albumQuery) ==  0){
                          echo ("<span class='noResults'> No Albums found matching ". $term. "<span>");
                    }
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
         <nav class='optionsMenu'>
            <input type='hidden' class='songId'> <!-- static variable  is  :: -->
            <?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
            
        </nav>

