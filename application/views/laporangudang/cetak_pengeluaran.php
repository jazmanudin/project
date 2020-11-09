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
    <title>LAPORAN PENGELUARAN BARANG</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN PENGELUARAN BARANG</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo DateToIndo2($dari); ?> S/D <?php echo DateToIndo2($sampai); ?></th>
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
                <th style="width: 2%;background-color:#0085cd;color:white" rowspan="2">No</th>
                <th style="width: 8%;background-color:#0085cd;color:white" rowspan="2">Tanggal Masuk</th>
                <th style="width: 15%;background-color:#0085cd;color:white" rowspan="2">No Pengeluaran</th>
                <th style="width: 15%;background-color:#0085cd;color:white" rowspan="2">Jenis Pengeluaran</th>
                <th style="width: 15%;background-color:#0085cd;color:white;text-align:center" colspan="5">Barang</th>
            </tr>
            <tr>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Kode barang</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Nama Barang</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Satuan</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Jenis Barang</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Jumlah</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $no           = 1;
            $qty          = 0;
            $total        = 0;
            foreach ($data as $key => $d) {
                $brg      = @$data[$key + 1]->kode_barang;
                $qty      += $d->qty;
                $total    += $qty;
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $d->tgl_transaksi; ?></td>
                    <td><?php echo $d->no_pengeluaran; ?></td>
                    <td><?php echo $d->jenis_pengeluaran; ?></td>
                    <td><?php echo $d->kode_barang; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td><?php echo $d->satuan; ?></td>
                    <td><?php echo $d->jenis_barang; ?></td>
                    <td align="center"><?php echo $d->qty; ?></td>
                </tr>
                <?php if ($brg != $d->kode_barang) { ?>
                    <tr bgcolor="#024a75" style="color:white; text-align: center">
                        <td colspan="8"></td>
                        <td align="center"><?php echo number_format($qty); ?></td>
                    </tr>
            <?php
                    $qty   = 0;
                }
            }
            ?>
            <tr bgcolor="#0085cd" style="color:white; text-align: center">
                <td colspan="8" style="text-align: center;">TOTAL</td>
                <td style="text-align: center;"><?php echo number_format($total); ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>