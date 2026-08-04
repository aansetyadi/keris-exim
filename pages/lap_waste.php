<?php
    include "proses/proses_waste.php";
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Penyelesaian Waste/Scrap
        </h1>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form method="post">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 text-nowrap">Periode Tanggal</label>
                        <input
                            type="date"
                            class="form-control form-control-sm"
                            id="tgl_awal"
                            name="tgl_awal"
                            value="<?= $tgl_awal ?>">
                        <span>s/d</span>
                        <input
                            type="date"
                            class="form-control form-control-sm"
                            id="tgl_akhir"
                            name="tgl_akhir"
                            value="<?= $tgl_akhir ?>">
                        <button type="submit" class="btn btn-primary btn-sm text-nowrap">
                            <i class="bi bi-search"></i>
                            Tampilkan
                        </button>
                    </div>
                </div>
                <div class="col ms-auto text-end">
                    <button 
                        type="button"
                        class="btn btn-secondary btn-sm"
                        onclick="cetak(
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
                        <col style="width:90px">   <!-- Jumlah -->
                        <col style="width:90px">   <!-- Nilai -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th colspan="2">BC 2.4</th>
                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Jumlah</th>
                            <th rowspan="2">Nilai</th>
                        </tr>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td class="rata-tengah"><?= $no++ ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['nomor']) ?></td>
                            <td class="rata-tengah"><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_barang']) ?></td>
                            <td class="nama-barang"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty'],2,',','.') ?></td>
                            <td class="rata-kanan"><?= number_format($row['nilai'],2,',','.') ?></td>
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