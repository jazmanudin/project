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
    <title>LAPORAN PEMBELIAN</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN PEMBELIAN</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo DateToIndo2($dari); ?> s/d <?php echo DateToIndo2($sampai); ?></th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">
                    <?php if ($kode_supplier != "") {
                        echo $supplier['nama_supplier'];
                    } else {
                        echo "Semua Supplier";
                    } ?>
                </th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="datatable3" style="width:120%">
        <thead>
            <tr>
                <th style="width: 8%;background-color:#0085cd;color:white">Tgl Transaksi</th>
                <th style="width: 8%;background-color:#0085cd;color:white">No Faktur</th>
                <th style="width: 8%;background-color:#0085cd;color:white">No PO</th>
                <th style="width: 8%;background-color:#0085cd;color:white">Kode Supplier</th>
                <th style="width: 20%;background-color:#0085cd;color:white">Nama Supplier</th>
                <th style="width: 8%;background-color:#0085cd;color:white">Jatuh Tempo</th>
                <th style="background-color:#0085cd;color:white">Keterangan</th>
                <th style="width: 8%;background-color:#0085cd;color:white">Jenis Transaksi</th>
                <th style="width: 3%;background-color:#0085cd;color:white">PPN</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:right">Total</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:right">Potongan</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:right">Subtotal</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $total      = 0;
            $subtotals  = 0;
            $totals  = 0;
            $potongan   = 0;
            $totpotongan   = 0;
            foreach ($data as $key => $d) {
                $spl    = @$data[$key + 1]->kode_supplier;
                $subtotal   = $d->total - $d->potongan;
                $total      += $d->total;
                $totals      += $d->total;
                $potongan   += $d->potongan;
                $totpotongan   += $d->potongan;
            ?>
                <tr>
                    <td><?php echo DateToIndo2($d->tgl_transaksi); ?></td>
                    <td><?php echo $d->no_fak_pemb; ?></td>
                    <td><?php echo $d->no_po; ?></td>
                    <td><?php echo $d->kode_supplier; ?></td>
                    <td><?php echo $d->nama_supplier; ?></td>
                    <td><?php echo DateToIndo2($d->jatuh_tempo); ?></td>
                    <td><?php echo $d->keterangan; ?></td>
                    <td><?php echo $d->jenis_transaksi; ?></td>
                    <td><?php echo $d->ppn; ?></td>
                    <td align="right"><?php echo number_format($d->total); ?></td>
                    <td align="right"><?php echo number_format($d->potongan); ?></td>
                    <td align="right"><?php echo number_format($subtotal); ?></td>
                </tr>
                <?php if ($spl != $d->kode_supplier and $kode_supplier == "") { ?>
                    <tr bgcolor="#024a75" style="color:white; text-align: right">
                        <td colspan="9"></td>
                        <td align="right"><?php echo number_format($total); ?></td>
                        <td align="right"><?php echo number_format($potongan); ?></td>
                        <td align="right"><?php echo number_format($total - $potongan); ?></td>
                    </tr>
            <?php
                    $total   = 0;
                    $potongan   = 0;
                }
            }
            ?>
            <tr>
                <th colspan="9" style="width: 7%;background-color:#0085cd;color:white;text-align:center">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totpotongan); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals - $totpotongan); ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>