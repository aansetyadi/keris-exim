<?php
include "proses/proses_pemakaian_raw.php";
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Pemakaian Bahan Baku
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
                            'Laporan Pemakaian Bahan Baku',
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
                        <col style="width:90px">   <!-- Nomor -->
                        <col style="width:90px">   <!-- Tanggal -->
                        <col style="width:70px">   <!-- Kode BB -->
                        <col style="width:300px">  <!-- Nama Barang -->
                        <col style="width:60px">   <!-- Satuan -->
                        <col style="width:70px">   <!-- Digunakan -->
                        <col style="width:70px">   <!-- Disubkontrakkan -->
                        <col style="width:80px">   <!-- Subkontrak -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th colspan="2">Bukti Pengeluaran</th>
                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Satuan</th>
                            <th colspan="2">Jumlah</th>
                            <th rowspan="2">Penerima Subkontrak</th>
                        </tr>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Digunakan</th>
                            <th>Disubkontrakkan</th>                
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
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_produksi']) ?></td>
                            <td class="rata-tengah"><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_raw']) ?></td>
                            <td class="nama-barang"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_aktual'],2,',','.') ?></td>
                            <td></td>
                            <td></td>
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
<script>
function cetak(){
    window.print();
}
</script>