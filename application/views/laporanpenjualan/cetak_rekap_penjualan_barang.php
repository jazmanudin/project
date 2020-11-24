<style>
    @page {
        size: A4
    }

    h3 {
        font-weight: bold;
        font-size: 15pt;
        text-align: center;
    }

    p {
        font-weight: bold;
        font-size: 12pt;
        text-align: center;
    }

    .judul {
        border-collapse: collapse;
        font-size: 12px;
        min-width: 100%;
        font-family: Roboto, HelveticaNeue, Arial, sans-serif;

    }

    .judul th {
        font-weight: bold;
        padding: 2px;
        text-align: left;
        font-size: 14px;
    }

    .datatable3 {
        border: 2px solid #D6DDE6;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 100%;
        font-family: Roboto, HelveticaNeue, Arial, sans-serif;

    }

    .datatable3 th {
        border: 2px solid #828282;
        font-weight: bold;
        padding: 5px;
        text-align: left;
        font-size: 14px;
    }

    .datatable3 td {
        border: 1px solid #000000;
        padding: 3px 3px;

    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LAPORAN REKAP PENJUALAN BARANG</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4" style="width: 70%;">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN REKAP PENJUALAN BARANG</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo DateToIndo2($dari); ?> s/d <?php echo DateToIndo2($sampai); ?></th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="datatable3">
        <thead>
            <tr>
                <th style="width: 8%;background-color:#0085cd;color:white">Kode Barang</th>
                <th style="background-color:#0085cd;color:white">Nama Barang</th>
                <th style="width: 10%;background-color:#0085cd;color:white;text-align:right">Total</th>
                <th style="width: 10%;background-color:#0085cd;color:white;text-align:right">Potongan</th>
                <th style="width: 10%;background-color:#0085cd;color:white;text-align:right">Total Netto</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $total          = 0;
            $totpotongan    = 0;
            foreach ($data as $key => $d) {
                $totpotongan    += $d->potongan;
                $total          += $d->total;
            ?>
                <tr>
                    <td><?php echo $d->kode_barang; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td align="right"><?php echo number_format($d->total); ?></td>
                    <td align="right"><?php echo number_format($d->potongan); ?></td>
                    <td align="right"><?php echo number_format($d->total - $d->potongan); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="2" style="width: 7%;background-color:#0085cd;color:white;text-align:center">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($total); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totpotongan); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($total - $totpotongan); ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>