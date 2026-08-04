<?php
include "proses/proses_mutasi_fg.php";
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Mutasi Hasil Produksi
        </h1>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form method="post">
            <div class="row g-2 mb-3 align-items-end">
                <!-- Filter tanggal + tombol tampilkan -->
                <div class="col-12 col-md">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-auto">
                            <label class="mb-1 d-block">Periode Tanggal</label>
                        </div>
                        <div class="col-12 col-md-auto">
                            <input type="date"
                                class="form-control form-control-sm filter-tanggal"
                                name="tgl_awal"
                                value="<?= $tgl_awal ?>">
                        </div>
                        <div class="col-12 col-md-auto d-flex align-items-center">
                            <span>s/d</span>
                        </div>
                        <div class="col-12 col-md-auto">
                            <input type="date"
                                class="form-control form-control-sm filter-tanggal"
                                name="tgl_akhir"
                                value="<?= $tgl_akhir ?>">
                        </div>
                        <div class="col-12 col-md-auto">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Tombol cetak pojok kanan -->
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cetak(
                            'printArea',
                            'Laporan Mutasi Hasil Produksi',
                            '<?=date('d-m-Y', strtotime($tgl_awal))?>',
                            '<?=date('d-m-Y', strtotime($tgl_akhir))?>'
                        )">
                        <i class="bi bi-printer"></i>
                        Cetak
                    </button>
                </div>
            </div>
        </form>
        <!-- Area yang akan dicetak -->
        <div id="printArea">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover small">
                    <colgroup>
                        <col style="width:40px">   <!-- No -->
                        <col style="width:70px">   <!-- Kode BB -->
                        <col style="width:400px">  <!-- Nama Barang -->
                        <col style="width:60px">   <!-- Satuan -->
                        <col style="width:80px">   <!-- Saldo Awal -->
                        <col style="width:80px">   <!-- Pemasukan -->
                        <col style="width:80px">   <!-- Pengeluaran -->
                        <col style="width:80px">   <!-- Saldo Awal -->
                        <col style="width:90px">   <!-- Gudang -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Saldo Awal</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Saldo Akhir</th>
                            <th>Gudang</th>
                        </tr>
                        <tr class="header-nomor">
                            <th>(1)</th>
                            <th>(2)</th>
                            <th>(3)</th>
                            <th>(4)</th>
                            <th>(5)</th>
                            <th>(6)</th>
                            <th>(7)</th>
                            <th>(8)</th>
                            <th>(9)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td class="rata-tengah"><?= $no++ ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_fg']) ?></td>
                            <td class="nama-barang"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_awal'],2,',','.') ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_masuk'],2,',','.') ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_keluar'],2,',','.') ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_akhir'],2,',','.') ?></td>
                            <td>PT. Batik Keris</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
            <!-- Akhir Table -->
        </div>
        <!-- AKhir Area yang akan dicetak -->
    </div>
</div>