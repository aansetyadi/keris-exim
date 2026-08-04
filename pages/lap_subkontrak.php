<?php
    $tgl_awal  = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
    $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Pemakaian Barang Dalam Rangka Kegiatan Subkontrak
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
                            'Laporan Pemakaian Barang Dalam Rangka Kegiatan Subkontrak',
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
                        <col style="width:65px">   <!-- Disubkontrakkan -->
                        <col style="width:80px">   <!-- Subkontrak -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th colspan="2">Bukti Pengeluaran barang</th>
                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Disubkontrakkan</th>
                            <th rowspan="2">Penerima Subkontrak</th>
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                </table>
            </div>
            <!-- Akhir Table -->
        </div>
        <!-- AKhir Area yang akan dicetak -->
    </div>
</div>