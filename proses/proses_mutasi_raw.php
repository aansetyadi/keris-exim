<?php
include "config/database.php";

    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $conn->exec("CREATE TEMP TABLE IF NOT EXISTS tampung_mutasi_raw(kode_raw character varying NOT NULL, qty_awal double precision, qty_masuk double precision, qty_keluar double precision, CONSTRAINT \"PK_mutasi_raw\" PRIMARY KEY (kode_raw));");
    $conn->exec("TRUNCATE TABLE tampung_mutasi_raw;");
    $sql = "INSERT INTO tampung_mutasi_raw(kode_raw, qty_awal) SELECT kode, SUM(masuk) - SUM(keluar) AS saldo FROM (SELECT kode_produk AS kode, SUM(qty) AS masuk, 0 AS keluar FROM impor WHERE tgl_pib < :tgl_awal GROUP BY kode_produk UNION ALL SELECT m.kode_raw, 0, SUM(m.qty_aktual) FROM produksi pr JOIN material m ON pr.kode_produksi = m.kode_produksi WHERE pr.tanggal < :tgl_awal AND pr.status='SELESAI' GROUP BY m.kode_raw UNION ALL SELECT kode_barang, 0, SUM(qty) FROM mutasi_raw_hapus WHERE tgl_mutasi < :tgl_awal AND kode_barang LIKE 'RM%' GROUP BY kode_barang) x GROUP BY kode ORDER BY kode;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->execute();

    $sql = "INSERT INTO tampung_mutasi_raw(kode_raw, qty_masuk) SELECT kode_produk, SUM(qty) AS qty_masuk FROM impor WHERE tgl_pib BETWEEN :tgl_awal AND :tgl_akhir GROUP BY kode_produk ON CONFLICT (kode_raw) DO UPDATE SET qty_masuk = EXCLUDED.qty_masuk;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();

    $sql = "INSERT INTO tampung_mutasi_raw(kode_raw, qty_keluar) SELECT kode, SUM(qty_keluar) FROM (SELECT m.kode_raw AS kode, SUM(m.qty_aktual) AS qty_keluar FROM produksi pr JOIN material m ON pr.kode_produksi = m.kode_produksi WHERE pr.tanggal BETWEEN :tgl_awal AND :tgl_akhir AND pr.status = 'SELESAI' GROUP BY m.kode_raw UNION ALL SELECT kode_barang AS kode, SUM(qty) AS qty_keluar FROM mutasi_raw_hapus WHERE tgl_mutasi BETWEEN :tgl_awal AND :tgl_akhir AND kode_barang LIKE 'RM%' GROUP BY kode_barang) x GROUP BY kode ON CONFLICT (kode_raw) DO UPDATE SET qty_keluar = EXCLUDED.qty_keluar;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();

    $sql = "SELECT t.kode_raw, p.nama, p.satuan, t.qty_awal, t.qty_masuk, t.qty_keluar, (COALESCE(t.qty_awal,0)+COALESCE(t.qty_masuk,0)-COALESCE(t.qty_keluar,0)) AS qty_akhir FROM tampung_mutasi_raw t LEFT JOIN produk p ON t.kode_raw = p.kode;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
?>