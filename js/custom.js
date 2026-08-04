function cetak(id, judul, tglAwal, tglAkhir) {

    var judulLama = document.title;
    document.title = judul;
    var area = document.getElementById(id);

    if (!area) {
        alert("Area cetak tidak ditemukan");
        return;
    }

    var header = area.querySelector(".print-header");
    var table = area.querySelector("table");
    if (!table) {
        alert("Tabel tidak ditemukan");
        return;
    }
    var tableWidth = table.offsetWidth;
    var pageWidth = 1100; // kira-kira lebar A4 landscape pixel
    var scale = pageWidth / tableWidth;
    if(scale > 1){
        scale = 1;
    }
    var width = 100 / scale;
    
    var iframe = document.createElement("iframe");

    iframe.style.position = "fixed";
    iframe.style.right = "0";
    iframe.style.bottom = "0";
    iframe.style.width = "0";
    iframe.style.height = "0";
    iframe.style.border = "0";

    document.body.appendChild(iframe);

    var doc = iframe.contentWindow.document;

    doc.open();

    doc.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>${judul}</title>
            <style>
                @page {
                    size: A4 landscape;
                    margin: 5mm;
                }
                html, body {
                    width: 100%;
                    overflow: hidden;
                    margin: 0;
                    padding: 0;
                }
                body {
                    font-family: Arial, sans-serif;
                    font-size: 10px;
                }
                .print-header-area {
                    text-align: center;
                    margin-bottom: 10px;
                }
                /*.print-table-area {
                    transform: scale(0.65);
                    transform-origin: top left;
                    width: 153%;
                }*/
                .print-header {
                    text-align: center;
                    margin-bottom: 10px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th,
                td {
                    border: 1px solid black;
                    padding: 4px 5px;
                    vertical-align: middle;
                }
                th {
                    text-align: center;
                }
                .rata-tengah {
                    text-align: center;
                }
                .rata-kanan {
                    text-align: right;
                    padding-right: 8px;
                }
                .nama-barang {
                    white-space: normal;
                    word-wrap: break-word;
                }
                .header {
                    margin-bottom: 8px;
                }
                .judul {
                    text-align: center;
                }
                .judul h4 {
                    margin: 0;
                    font-size: 16px;
                }
                .judul h5 {
                    margin: 1px 0;
                    font-size: 14px;
                }
                .alamat {
                    margin: 0;
                    font-size: 10px;
                }
                .periode {
                    margin-top: 5px;
                    text-align: left;
                    font-size: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="judul">
                    <h4>${judul}</h4>
                    <h5>PT. BATIK KERIS</h5>
                    <div class="alamat">
                        Jl. Batik Keris No.1, Turi, Cemani, Kec. Grogol, Kabupaten Sukoharjo
                    </div>
                </div>
                <div class="periode">
                    Periode : ${tglAwal} s/d ${tglAkhir}
                </div>
            </div>
            <div class="print-table-area" style="transform:scale(${scale}); transform-origin: top left; width:${width}%;">
                ${table.outerHTML}
            </div>            
        </body>
        </html>
    `);

    doc.close();
    iframe.onload = function () {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        setTimeout(function () {
            document.title = judulLama;
            document.body.removeChild(iframe);
        }, 10);
    };
}