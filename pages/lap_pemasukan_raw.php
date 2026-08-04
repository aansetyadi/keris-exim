<?php
include "proses/proses_pemasukan_raw.php";
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Pemasukan Bahan Baku
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
                            'Laporan Pemasukan Bahan Baku',
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
                        <col style="width:40px">    <!-- No -->
                        <col style="width:90px">    <!-- Tgl Rekam -->
                        <col style="width:65px">    <!-- Jenis Dokumen -->
                        <col style="width:90px">   <!-- No PIB -->
                        <col style="width:90px">    <!-- Tgl PIB -->
                        <col style="width:90px">   <!-- Kode HS -->
                        <col style="width:60px">    <!-- No Seri -->
                        <col style="width:100px">   <!-- No Mutasi -->
                        <col style="width:90px">    <!-- Tgl Mutasi -->
                        <col style="width:70px">    <!-- Kode BB -->
                        <col style="width:300px">   <!-- Nama Barang -->
                        <col style="width:60px">    <!-- Satuan -->
                        <col style="width:70px">    <!-- Jumlah -->
                        <col style="width:70px">    <!-- Mata Uang -->
                        <col style="width:90px">   <!-- Nilai -->
                        <col style="width:90px">   <!-- Gudang -->
                        <col style="width:80px">   <!-- Subkontrak -->
                        <col style="width:80px">   <!-- Negara -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Tgl Rekam</th>
                            <th colspan="1">Jenis Dokumen</th>
                            <th colspan="4">Dokumen Pabean</th>
                            <th colspan="2">Bukti Penerimaan Barang</th>
                            <th rowspan="2">Kode BB</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Jumlah</th>
                            <th rowspan="2">Mata Uang</th>
                            <th rowspan="2">Nilai Barang</th>
                            <th rowspan="2">Gudang</th>
                            <th rowspan="2">Penerima Subkontrak</th>
                            <th rowspan="2">Negara Asal BB</th>
                        </tr>
                        <tr>
                            <th>BC 2.0/BC 2.4/BC 2.5/BC 2.8</th>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Kode HS</th>
                            <th>No. Seri barang</th>
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
                            <th>(9)</th>
                            <th>(10)</th>
                            <th>(11)</th>
                            <th>(12)</th>
                            <th>(13)</th>
                            <th>(14)</th>
                            <th>(15)</th>
                            <th>(16)</th>
                            <th>(17)</th>
                            <th>(18)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td class="rata-tengah"><?= $no++ ?></td>
                            <td class="rata-tengah"><?= date('d-m-Y', strtotime($row['tgl_rekam'])) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['jenis_bc']) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['nomor_pib']) ?></td>
                            <td class="rata-tengah"><?= $row['tgl_pib'] ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_hs']) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['no_seri']) ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['no_mutasi']) ?></td>
                            <td class="rata-tengah"><?= $row['tgl_mutasi'] ?></td>
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode']) ?></td>
                            <td class="nama-barang"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty'],2,',','.') ?></td>
                            <td><?= htmlspecialchars($row['mata_uang']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['nilai'],2,',','.') ?></td>
                            <td>PT. Batik Keris</td>
                            <td></td>
                            <td><?= htmlspecialchars($row['negara']) ?></td>
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