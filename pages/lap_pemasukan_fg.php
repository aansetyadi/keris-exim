<?php
include "proses/proses_pemasukan_fg.php";
?>
<div class="card">
    <div class="card-header">
        <h1 class="card-title">
            Laporan Pemasukan Hasil Produksi
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
                    <button type="button" class="btn btn-success btn-sm" onclick="exportExcel()">
                        <i class="bi bi-file-earmark-excel"></i>
                        Excel
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cetak(
                            'printArea',
                            'Laporan Pemasukan Hasil Produksi',
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
                            <th colspan="2">Dokumen</th>
                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Satuan</th>
                            <th colspan="2">Jumlah</th>
                            <th rowspan="2">Gudang</th>
                        </tr>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>dari produksi</th>
                            <th>dari subkontrak</th>                
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
                            <td class="rata-tengah"><?= htmlspecialchars($row['kode_fg']) ?></td>
                            <td class="nama-barang"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="rata-kanan"><?= number_format($row['qty_aktual'],2,',','.') ?></td>
                            <td></td>
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
<script>
function exportExcel() {

    var originalTable = document.querySelector('#printArea table');

    if (!originalTable) {
        alert('Data tabel tidak ditemukan.');
        return;
    }
    var table = originalTable.cloneNode(true);
    table.querySelectorAll('thead tr.header-nomor th').forEach(function(cell) {

        var text = cell.textContent.trim();
        text = text.replace(/\(/g, '').replace(/\)/g, '');

        cell.textContent = text;
    });
    table.querySelectorAll('th, td').forEach(function(cell) {

        cell.style.border = '1px solid #999';
        cell.style.padding = '4px';
        cell.style.verticalAlign = 'middle';
    });
    var judul = `
        <table style="border-collapse:collapse; width:100%;">
            <tr>
                <td colspan="9" style="
                    font-size:18px;
                    font-weight:bold;
                    text-align:center;
                    border:none;
                ">
                    Laporan Pemasukan Hasil Produksi
                </td>
            </tr>

            <tr>
                <td colspan="9" style="
                    font-size:14px;
                    font-weight:bold;
                    text-align:center;
                    border:none;
                ">
                    PT.BATIK KERIS
                </td>
            </tr>

            <tr>
                <td colspan="9" style="
                    font-size:12px;
                    text-align:center;
                    border:none;
                ">
                    Jl. Batik Keris No.1, Turi, Cemani, Kec. Grogol, Kab. Sukoharjo
                </td>
            </tr>

            <tr>
                <td colspan="9" style="
                    height:20px;
                    border:none;
                ">
                    &nbsp;
                </td>
            </tr>
        </table>
    `;
    var html = `
    <html xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel">

    <head>
        <meta charset="UTF-8">

        <style>

            table {
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #999;
                padding: 4px;
                vertical-align: middle;
            }

            th {
                font-weight: bold;
                text-align: center;
            }

        </style>

    </head>

    <body>

        ${judul}

        ${table.outerHTML}

    </body>

    </html>
    `;
    var blob = new Blob(
        ['\ufeff' + html],
        {
            type: 'application/vnd.ms-excel'
        }
    );

    var url = URL.createObjectURL(blob);

    var a = document.createElement('a');

    a.href = url;

    a.download =
        'Laporan_Pemasukan_Hasil_Produksi_' +
        '<?=date("dmY", strtotime($tgl_awal))?>' +
        '_' +
        '<?=date("dmY", strtotime($tgl_akhir))?>' +
        '.xls';

    document.body.appendChild(a);

    a.click();

    document.body.removeChild(a);

    URL.revokeObjectURL(url);
}
</script>