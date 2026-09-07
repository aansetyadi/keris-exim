<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT pr.no_mutasi, TO_CHAR(tgl_mutasi, 'dd-MM-yyyy') AS tgl, pr.kode_barang, p.nama, p.satuan, pr.qty 
            FROM mutasi_fg_in pr LEFT JOIN produk p ON pr.kode_barang = p.kode 
            WHERE pr.tgl_mutasi BETWEEN :tgl_awal AND :tgl_akhir AND pr.status = 'TERIMA' ORDER BY pr.no_mutasi";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>