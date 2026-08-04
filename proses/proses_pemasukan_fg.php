<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT pr.kode_produksi, TO_CHAR(tanggal, 'dd-MM-yyyy') AS tgl, pr.kode_fg, p.nama, pr.satuan, pr.qty_aktual 
            FROM produksi pr LEFT JOIN produk p ON pr.kode_fg = p.kode 
            WHERE pr.tanggal BETWEEN :tgl_awal AND :tgl_akhir AND pr.status = 'SELESAI' ORDER BY pr.kode_produksi";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>