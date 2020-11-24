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
    <title>LAPORAN BARANG KADALUARSA</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN BARANG KADALUARSA</th>
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
                <th style="width: 2%;background-color:#0085cd;color:white;text-align:center">No</th>
                <th style="width: 8%;background-color:#0085cd;color:white;text-align:center">Kode Barang</th>
                <th style="width: 20%;background-color:#0085cd;color:white;text-align:center">Nama Barang</th>
                <th style="width: 5%;background-color:#0085cd;color:white;text-align:center">Satuan</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center">Kategori</th>
                <th style="background-color:#0085cd;color:white;text-align:center">Keterangan</th>
                <th style="width: 10%;background-color:#0085cd;color:white;text-align:center">Exp Date</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center">Sisa Hari</th>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $no                     = 1;
            foreach ($data as $d) {
                $brg        = @$data[$key + 1]->exp_date;
                $exp = $d->exp_date;
                $skr = date('Y-m-d');
                $tgl1 = new DateTime("$exp");
                $tgl2 = new DateTime("$skr");
                $sisa = $tgl2->diff($tgl1)->days + 1;

            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d->kode_barang; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td><?php echo $d->satuan; ?></td>
                    <td><?php echo $d->nama_kategori; ?></td>
                    <td><?php echo $d->keterangan; ?></td>
                    <td><?php echo dateToIndo2($d->exp_date); ?></td>
                    <td align="center"><?php echo $sisa; ?></td>
                </tr>
                <?php if ($brg != $d->exp_date) { ?>
                    <tr bgcolor="#024a75" style="color:white; text-align: right">
                        <td style="color:#024a75" colspan="8">.</td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>