<?php
if(isset($_SESSION['log'])){

} else {
    //Jika belum login
    header('location:login.php');
}
?>