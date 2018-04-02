        <?php
		    include("includes/includedFiles.php");
		
		 ?>
			  <h1 class="pageHeadingBig"> 	Albums </h1>
              <div class="gridViewContainer"> 
				 <?php 
				    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10" );
					while($row = mysqli_fetch_array($albumQuery)){
						echo "
						 <div class='gridViewItem'>
						   <span onclick='openPage(\"album.php?id=".$row['id']."\")'>
						   <img style='height:150px' src='".$row['artPath']."'>

						   <div class='gridViewInfo'>
                              ".$row['title']."
						   </div>
						   </span>
						 </div>";
					} 
				 ?>
			  </div> 
