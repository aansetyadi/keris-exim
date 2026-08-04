<?php
include "config/database.php";

    // Default tanggal
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $sql = "SELECT r.tgl_mutasi AS tgl_rekam, i.jenis_bc, i.nomor_pib, TO_CHAR(i.tgl_pib,'DD-MM-YYYY') AS tgl_pib, i.kode_hs, i.runno AS no_seri, r.no_mutasi, TO_CHAR(r.tgl_mutasi,'DD-MM-YYYY') AS tgl_mutasi, p.kode, p.nama, i.satuan, i.qty, i.mata_uang, i.nilai, i.negara 
            FROM impor i JOIN mutasi_raw_in r ON i.nomor_pib = r.no_pib AND i.kode_produk = r.kode_barang LEFT JOIN produk p ON i.kode_produk = p.kode 
            WHERE r.no_mutasi ILIKE 'RMI%' AND i.tgl_pib BETWEEN :tgl_awal AND :tgl_akhir ORDER BY i.tgl_pib,i.runno";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();
?>