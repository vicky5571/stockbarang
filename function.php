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
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, qty, penerima) values('$barangnya','$qty','$penerima')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

//Menambah Barang Keluar
if(isset($_POST['addBarangKeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, qty, penerima) values('$barangnya','$qty','$penerima')");
    $updatestockkeluar = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockkeluar){
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

//Update info Stock
if(isset($_POST['editstock'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    
    $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', stock='$stock' where idbarang='$idb'");
    if($update){
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//Menghapus barang dari Stock
if(isset($_POST['deletestock'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        header('location:index.php');
    }
}

//Mengubah data barang masuk
if(isset($_POST['editmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',penerima='$penerima' where idmasuk='$idm'");
            if($kurangistocknya && $updatenya){
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
    } else {
        $selisih = $qtyskrg - $qty;
        $tambahin = $stockskrg - $selisih;
        $tambahstocknya = mysqli_query($conn, "update stock set stock='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',penerima='$penerima' where idmasuk='$idm'");
            if($tambahstocknya && $updatenya){
                header('location:masuk.php');
            } else {
                header('location:masuk.php');
            }
    }
}

//Menghapus Barang Masuk
if(isset($_POST['deletemasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update && $hapusdata){
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

//Mengubah data Barang Keluar
if(isset($_POST['editkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'");
            if($kurangistocknya && $updatenya){
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
    } else {
        $selisih = $qtyskrg - $qty;
        $tambahin = $stockskrg + $selisih;
        $tambahstocknya = mysqli_query($conn, "update stock set stock='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'");
            if($tambahstocknya && $updatenya){
                header('location:keluar.php');
            } else {
                header('location:keluar.php');
            }
    }
}

//Menghapus Barang Keluar
if(isset($_POST['deletekeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update && $hapusdata){
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

?>