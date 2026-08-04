<?php
include "config/database.php";

    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');

    $conn->exec("CREATE TEMP TABLE IF NOT EXISTS tampung_mutasi_fg(kode_fg character varying NOT NULL, qty_awal double precision, qty_masuk double precision,qty_keluar double precision, CONSTRAINT \"PK_mutasi_fg\" PRIMARY KEY (kode_fg));");
    $conn->exec("TRUNCATE TABLE tampung_mutasi_fg;");
    $sql = "INSERT INTO tampung_mutasi_fg(kode_fg, qty_awal) SELECT kode, SUM(masuk) - SUM(keluar) AS saldo FROM (SELECT kode_produk AS kode, 0 AS masuk, SUM(qty) AS keluar FROM expor WHERE tgl_peb < :tgl_awal GROUP BY kode_produk UNION ALL SELECT kode_fg, SUM(qty_aktual), 0 FROM produksi WHERE tanggal < :tgl_awal AND status='SELESAI' GROUP BY kode_fg UNION ALL SELECT kode_barang, 0, SUM(qty) FROM scrap WHERE tanggal < :tgl_awal AND kode_barang LIKE 'FG%' GROUP BY kode_barang) x GROUP BY kode ORDER BY kode;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->execute();

    $sql = "INSERT INTO tampung_mutasi_fg(kode_fg, qty_masuk) SELECT kode_fg, SUM(pr.qty_aktual) AS qty_masuk FROM produksi pr WHERE tanggal BETWEEN :tgl_awal AND :tgl_akhir AND pr.status = 'SELESAI' GROUP BY kode_fg ON CONFLICT (kode_fg) DO UPDATE SET qty_masuk = EXCLUDED.qty_masuk;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();

    $sql = "INSERT INTO tampung_mutasi_fg(kode_fg, qty_keluar) SELECT kode, SUM(qty_keluar) FROM (SELECT kode_produk AS kode, SUM(qty) AS qty_keluar FROM expor WHERE tgl_peb BETWEEN :tgl_awal AND :tgl_akhir GROUP BY kode_produk UNION ALL SELECT kode_barang AS kode, SUM(qty) AS qty_keluar FROM scrap WHERE tanggal BETWEEN :tgl_awal AND :tgl_akhir AND kode_barang LIKE 'FG%' GROUP BY kode_barang) x GROUP BY kode ON CONFLICT (kode_fg) DO UPDATE SET qty_keluar = EXCLUDED.qty_keluar;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tgl_awal', $tgl_awal);
    $stmt->bindParam(':tgl_akhir', $tgl_akhir);
    $stmt->execute();

    $sql = "SELECT t.kode_fg, p.nama, p.satuan, t.qty_awal, t.qty_masuk, t.qty_keluar, (COALESCE(t.qty_awal,0)+COALESCE(t.qty_masuk,0)-COALESCE(t.qty_keluar,0)) AS qty_akhir FROM tampung_mutasi_fg t LEFT JOIN produk p ON t.kode_fg = p.kode;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
?>