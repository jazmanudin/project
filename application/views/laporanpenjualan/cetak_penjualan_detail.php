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
    <title>LAPORAN DETAIL PENJUALAN</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN DETAIL PENJUALAN</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo DateToIndo2($dari); ?> s/d <?php echo DateToIndo2($sampai); ?></th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">
                    <?php if ($kode_barang != "") {
                        echo $barang['nama_barang'];
                    } else {
                        echo "Semua Barang";
                    } ?>
                </th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="datatable3">
        <thead>
            <tr>
                <th style="width: 12%;background-color:#0085cd;color:white" rowspan="2">Tgl Transaksi</th>
                <th style="width: 10%;background-color:#0085cd;color:white" rowspan="2">No Faktur</th>
                <th style="width: 10%;background-color:#0085cd;color:white;text-align:center" colspan="6">Barang</th>
            </tr>
            <tr>
                <th style="width: 8%;background-color:#024a75;color:white">Kode</th>
                <th style="background-color:#024a75;color:white">Nama Barang</th>
                <th style="width: 5%;background-color:#024a75;color:white">Satuan</th>
                <th style="width: 7%;background-color:#024a75;color:white;text-align:right">Harga</th>
                <th style="width: 5%;background-color:#024a75;color:white;text-align:center">Qty</th>
                <th style="width: 7%;background-color:#024a75;color:white;text-align:right">Subtotal</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $total          = 0;
            $totals         = 0;
            $qty            = 0;
            $totqty         = 0;
            foreach ($data as $key => $d) {
                $brg        = @$data[$key + 1]->kode_barang;
                $subtotal   = ($d->qty * $d->harga_jual);

                $total      += $subtotal;
                $qty        += $d->qty;

                $totqty     += $d->qty;
                $totals     += $subtotal;
            ?>
                <tr>
                    <td><?php echo DateToIndo2($d->tgl_transaksi); ?></td>
                    <td><?php echo $d->no_fak_penj; ?></td>
                    <td><?php echo $d->kode_barang; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td><?php echo $d->satuan; ?></td>
                    <td align="right"><?php echo number_format($d->harga_jual); ?></td>
                    <td align="center"><?php echo number_format($d->qty); ?></td>
                    <td align="right"><?php echo number_format($subtotal); ?></td>
                </tr>
                <?php if ($brg != $d->kode_barang AND $kode_barang == "") { ?>
                    <tr bgcolor="#024a75" style="color:white; text-align: right">
                        <td colspan="6"></td>
                        <td align="center"><?php echo number_format($qty); ?></td>
                        <td align="right"><?php echo number_format($total); ?></td>
                    </tr>
            <?php
                    $qty   = 0;
                    $total   = 0;
                }
            }
            ?>
            <tr>
                <th colspan="6" style="width: 7%;background-color:#0085cd;color:white;text-align:center">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($totqty); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals); ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>