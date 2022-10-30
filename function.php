<?php
session_start();

//Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");
// "host" "username" "password" "nama db"

//Menambah Barang Baru
if(isset($_POST['addNewBarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//Menambah Barang Masuk
if(isset($_POST['addBarangMasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, keterangan) values('$barangnya','$penerima')");
    if($addtomasuk){
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}
?>