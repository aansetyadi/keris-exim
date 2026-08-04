<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT s.nomor, TO_CHAR(tanggal, 'dd-MM-yyyy') AS tgl, s.kode_barang, p.nama, s.satuan, s.qty, s.nilai 
            FROM scrap s LEFT JOIN produk p ON s.kode_barang = p.kode 
            WHERE s.tanggal BETWEEN :tgl_awal AND :tgl_akhir ORDER BY s.nomor";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>