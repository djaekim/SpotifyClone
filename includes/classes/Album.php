<?php
   class Album{
       private $con;
       private $id;
       private $album;

       public function __construct($con, $id){
           $this->con = $con;
           $this->id = $id;
           $albumQuery = mysqli_query ($this->con, "SELECT * FROM albums WHERE id='$this->id'");
           $album = mysqli_fetch_array($albumQuery);
           $this->album = $album;
       }
       public function getTitle(){
            return $this->album['title'];
       }
       public function getArtist(){
            return new Artist($this->con, $this->album['artist']);
       }
       public function getGenre(){
            return $this->album['genre'];
       }
       public function getArtPath(){
            return $this->album['artPath'];
       }
       public function getNumbSongs(){
            $query = mysqli_query($this->con, "SELECT * FROM songs WHERE album='$this->id'");
            $result = mysqli_num_rows($query);
            return $result;
       }
       public function getSongIds(){
           $query = mysqli_query($this->con, "SELECT * FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
           $array = array();
           while($row = mysqli_fetch_array($query)){
              array_push($array, $row['id']);
           }
           return $array;
       }
   }



?>