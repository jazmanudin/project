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
    <title>LAPORAN REKAP PERSEDIAAN BARANG</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
</head>
<?php if ($bulan == "01") {
    $bulan = "Januari";
} elseif ($bulan == "02") {
    $bulan = "Februari";
} elseif ($bulan == "03") {
    $bulan = "Maret";
} elseif ($bulan == "04") {
    $bulan = "April";
} elseif ($bulan == "05") {
    $bulan = "Mei";
} elseif ($bulan == "06") {
    $bulan = "Juni";
} elseif ($bulan == "07") {
    $bulan = "Juli";
} elseif ($bulan == "08") {
    $bulan = "Agustus";
} elseif ($bulan == "09") {
    $bulan = "September";
} elseif ($bulan == "10") {
    $bulan = "Oktober";
} elseif ($bulan == "11") {
    $bulan = "November";
} elseif ($bulan == "12") {
    $bulan = "Desember";
} ?>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN REKAP PERSEDIAAN BARANG</th>
            </tr>
            <tr>
                <th colspan="9" style="text-align: center;">Periode <?php echo $bulan; ?> <?php echo $tahun; ?></th>
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
                <th style="width: 8%;background-color:#0085cd;color:white" rowspan="2">Kode Barang</th>
                <th style="width: 15%;background-color:#0085cd;color:white" rowspan="2">Nama Barang</th>
                <th style="width: 5%;background-color:#0085cd;color:white" rowspan="2">Satuan</th>
                <th style="background-color:#0085cd;color:white;text-align:center" rowspan="2">Saldo Awal</th>
                <th style="background-color:#0085cd;color:white;text-align:center" colspan="3">Pemasukan</th>
                <th style="background-color:#0085cd;color:white;text-align:center" colspan="4">Pengeluaran</th>
                <th style="background-color:#0085cd;color:white;text-align:center" rowspan="2">Saldo Akhir</th>
                <th style="background-color:#0085cd;color:white;text-align:center" rowspan="2">Opname Stok</th>
                <th style="background-color:#0085cd;color:white;text-align:center" rowspan="2">Selisih</th>
            </tr>
            <tr>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Pembelian</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Retur Kembali</th>
                <th style="width: 8%;background-color:#151f48;color:white;text-align:center">Lainnya</th>
                <th style="background-color:#151f48;color:white;text-align:center">Penjualan</th>
                <th style="background-color:#151f48;color:white;text-align:center">Retur</th>
                <th style="background-color:#151f48;color:white;text-align:center">Buang</th>
                <th style="background-color:#151f48;color:white;text-align:center">Lainnya</th>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $no                     = 1;
            $saldoawal              = 0;
            $qtypembelian           = 0;
            $qtyreturkembali        = 0;
            $qtymasuklainnya        = 0;
            $qtypenjualan           = 0;
            $qtyretur               = 0;
            $qtybuang               = 0;
            $qtykeluarlainnya       = 0;
            $totsaldoakhir          = 0;
            $totopname              = 0;
            $totselisih             = 0;
            foreach ($data as $d) {
                $saldoawal          += $d->qtysaldoawal;
                $qtypembelian       += $d->qtypembelian;
                $qtyreturkembali    += $d->qtyreturkembali;
                $qtymasuklainnya    += $d->qtymasuklainnya;
                $qtypenjualan       += $d->qtypenjualan;
                $qtyretur           += $d->qtyretur;
                $qtybuang           += $d->qtybuang;
                $qtykeluarlainnya   += $d->qtykeluarlainnya;
                $saldoakhir         = ($d->qtysaldoawal + $d->qtypembelian + $d->qtyreturkembali + $d->qtymasuklainnya) - ($d->qtypenjualan + $d->qtyretur + $d->qtybuang + $d->qtykeluarlainnya);
                $selisih            = $saldoakhir - $d->qtyopname;

                $pemasukan          = $d->qtypembelian + $d->qtyreturkembali + $d->qtymasuklainnya;
                $pengeluaran        = $d->qtypenjualan + $d->qtyretur + $d->qtybuang + $d->qtykeluarlainnya;

                $totsaldoakhir      += $saldoakhir;
                $totselisih         += $selisih;
                $totopname          += $d->qtyopname;

            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $d->kode_barang; ?></td>
                    <td><?php echo $d->nama_barang; ?></td>
                    <td><?php echo $d->satuan; ?></td>
                    <td align="center">
                        <?php if (!empty($d->qtysaldoawal)) {
                            echo number_format($d->qtysaldoawal);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtypembelian)) {
                            echo number_format($d->qtypembelian);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtyreturkembali)) {
                            echo number_format($d->qtyreturkembali);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtymasuklainnya)) {
                            echo number_format($d->qtymasuklainnya);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtypenjualan)) {
                            echo number_format($d->qtypenjualan);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtyretur)) {
                            echo number_format($d->qtyretur);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtybuang)) {
                            echo number_format($d->qtybuang);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtykeluarlainnya)) {
                            echo number_format($d->qtykeluarlainnya);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($saldoakhir)) {
                            echo number_format($saldoakhir);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($d->qtyopname)) {
                            echo number_format($d->qtyopname);
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!empty($selisih)) {
                            echo number_format($selisih);
                        } ?>
                    </td>
                </tr>
            <?php
                $no++;
            } ?>
            <tr>
                <th colspan="4" style="width: 7%;background-color:#0085cd;color:white;text-align:center">Total</th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($saldoawal); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtypembelian); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtyreturkembali); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtymasuklainnya); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtypenjualan); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtyretur); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtybuang); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($qtykeluarlainnya); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($totsaldoakhir); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($totopname); ?></th>
                <th style="width: 7%;background-color:#0085cd;color:white;text-align:center"><?php echo number_format($totselisih); ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>