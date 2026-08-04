<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT nomor_peb, TO_CHAR(tgl_peb, 'dd-MM-yyyy') AS tglpeb, f.no_mutasi, TO_CHAR(tgl_mutasi, 'dd-MM-yyyy') AS tglmutasi, b.nama AS pembeli, b.negara, p.kode, p.nama, i.satuan, i.qty, i.mata_uang, i.nilai 
            FROM expor i JOIN mutasi_fg_out f ON i.nomor_peb = f.no_peb AND i.kode_produk = f.kode_barang LEFT JOIN produk p ON i.kode_produk = p.kode LEFT JOIN buyer b ON i.kode_buyer = b.kode 
            WHERE f.status = 'TERIMA' AND tgl_peb BETWEEN :tgl_awal AND :tgl_akhir ORDER BY tgl_peb";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>