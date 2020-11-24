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
    <title>LAPORAN KARTU HUTANG</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN KARTU HUTANG</th>
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
    <table class="datatable3">
        <thead>
            <tr>
                <th style="width: 9%;background-color:#0085cd;color:white">Tgl Transaksi</th>
                <th style="width: 7%;background-color:#0085cd;color:white">No Faktur</th>
                <th style="width: 8%;background-color:#0085cd;color:white">Kode Supplier</th>
                <th style="width: 18%;background-color:#0085cd;color:white">Nama Supplier</th>
                <th style="width: 9%;background-color:#0085cd;color:white">Jatuh Tempo</th>
                <th style="background-color:#0085cd;color:white">Keterangan</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right">Potongan</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right">Subtotal</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:right">Jumlah Bayar</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:right">Sisa Bayar</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $total      = 0;
            $subtotals  = 0;
            $totals  = 0;
            $potongan   = 0;
            $jumlahbayar   = 0;
            $totpotongan   = 0;
            $totjumlahbayar   = 0;
            foreach ($data as $key => $d) {
                $spl    = @$data[$key + 1]->kode_supplier;
                $subtotal   = $d->total - $d->potongan;
                $sisabayar   = $d->total - $d->potongan - $d->jumlahbayar;
                $total      += $d->total;
                $totals      += $d->total;
                $potongan   += $d->potongan;
                $jumlahbayar   += $d->jumlahbayar;
                $totjumlahbayar   += $d->jumlahbayar;
                $totpotongan   += $d->potongan;

                $tanggal        = $d->tgl_transaksi;
                $jatuhtempo     = Date('Y-m-d', strtotime('+' . $d->jatuh_tempo . ' days', strtotime($tanggal)));
            ?>
                <tr>
                    <td><?php echo DateToIndo2($d->tgl_transaksi); ?></td>
                    <td><?php echo $d->no_fak_pemb; ?></td>
                    <td><?php echo $d->kode_supplier; ?></td>
                    <td><?php echo $d->nama_supplier; ?></td>
                    <td><?php echo DateToIndo2($jatuhtempo); ?></td>
                    <td><?php echo $d->keterangan; ?></td>
                    <td align="right"><?php echo number_format($d->total); ?></td>
                    <td align="right"><?php echo number_format($d->potongan); ?></td>
                    <td align="right"><?php echo number_format($subtotal); ?></td>
                    <td align="right"><?php echo number_format($d->jumlahbayar); ?></td>
                    <td align="right"><?php echo number_format($sisabayar); ?></td>
                </tr>
                <?php if ($spl != $d->kode_supplier and $kode_supplier == "") { ?>
                    <tr bgcolor="#024a75" style="color:white; text-align: right">
                        <td colspan="6"></td>
                        <td align="right"><?php echo number_format($total); ?></td>
                        <td align="right"><?php echo number_format($potongan); ?></td>
                        <td align="right"><?php echo number_format($total - $potongan); ?></td>
                        <td align="right"><?php echo number_format($jumlahbayar); ?></td>
                        <td align="right"><?php echo number_format($total - $potongan - $jumlahbayar); ?></td>
                    </tr>
            <?php
                    $total   = 0;
                    $potongan   = 0;
                    $jumlahbayar   = 0;
                }
            }
            ?>
            <tr>
                <th colspan="6" style="width: 7%;background-color:#0085cd;color:white;text-align:center">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totpotongan); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals - $totpotongan); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totjumlahbayar); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:right"><?php echo number_format($totals - $totpotongan - $totjumlahbayar); ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>