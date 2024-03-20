<?php
function logedIn(){
    if(!isset($_SESSION['profil'])){
        header('Location: index.php');
        exit;
      }
}