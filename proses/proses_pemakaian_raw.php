<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT m.kode_produksi, TO_CHAR(tanggal, 'dd-MM-yyyy') AS tgl, m.kode_raw, p.nama, m.satuan, m.qty_aktual 
            FROM produksi pr JOIN material m ON pr.kode_produksi = m.kode_produksi LEFT JOIN produk p ON m.kode_raw = p.kode 
            WHERE pr.tanggal BETWEEN :tgl_awal AND :tgl_akhir AND pr.status = 'SELESAI' ORDER BY m.kode_produksi";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>