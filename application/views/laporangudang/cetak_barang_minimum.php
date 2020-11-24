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
    <title>LAPORAN BARANG STOK MINIMUM</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN BARANG STOK MINIMUM</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo dateToIndo2(date('Y-m-d')); ?></th>
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
                <th style="width: 2%;background-color:#0085cd;color:white;text-align:center" rowspan="2">No</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Kode Barang</th>
                <th style="width: 20%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Nama Barang</th>
                <th style="width: 5%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Satuan</th>
                <th style="width: 5%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Kategori</th>
                <th style="width: 5%;background-color:#0085cd;color:white;text-align:center" colspan="6">Harga</th>
                <th style="background-color:#0085cd;color:white;text-align:center" rowspan="2">Keterangan</th>
                <th style="width: 6%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Stok Min</th>
                <th style="width: 6%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Stok</th>
            </tr>
            <tr>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">Modal</th>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">Grosir</th>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">Eceran</th>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">PT</th>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">PTT</th>
                <th style="width: 6%;background-color:151f48;color:white;text-align:center">Lainnya</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $no                     = 1;
            foreach ($data as $d) {
                if ($d->stok <= $d->min_stok) {
            ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->satuan; ?></td>
                        <td><?php echo $d->nama_kategori; ?></td>
                        <td align="right">
                            <?php if (!empty($d->harga_modal)) {
                                echo number_format($d->harga_modal);
                            } ?>
                        </td>
                        <td align="right">
                            <?php if (!empty($d->grosir)) {
                                echo number_format($d->grosir);
                            } ?>
                        </td>
                        <td align="right">
                            <?php if (!empty($d->eceran)) {
                                echo number_format($d->eceran);
                            } ?>
                        </td>
                        <td align="right">
                            <?php if (!empty($d->pelanggan_tetap)) {
                                echo number_format($d->pelanggan_tetap);
                            } ?>
                        </td>
                        <td align="right">
                            <?php if (!empty($d->tidak_tetap)) {
                                echo number_format($d->tidak_tetap);
                            } ?>
                        </td>
                        <td align="right">
                            <?php if (!empty($d->lainnya)) {
                                echo number_format($d->lainnya);
                            } ?>
                        </td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="center">
                            <?php if (!empty($d->min_stok)) {
                                echo number_format($d->min_stok);
                            } ?>
                        </td>
                        <td align="center">
                            <?php if (!empty($d->stok)) {
                                echo number_format($d->stok);
                            } ?>
                        </td>
                    </tr>
            <?php
                    $no++;
                }
            } ?>
        </tbody>
    </table>
</body>

</html>