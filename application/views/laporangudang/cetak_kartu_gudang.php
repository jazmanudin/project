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
    <title>LAPORAN KARTU GUDANG</title>
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
} 

error_reporting(0);

?>

<body class="A4">
    <table class="judul">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center;">LAPORAN KARTU GUDANG</th>
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
                <th style="width: 6%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Tanggal</th>
                <th style="background-color:#0085cd;color:white;text-align:center" colspan="3">Pemasukan</th>
                <th style="background-color:#0085cd;color:white;text-align:center" colspan="4">Pengeluaran</th>
                <th style="background-color:#0085cd;color:white;text-align:center">Saldo Akhir</th>
            </tr>
            <tr>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Pembelian</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Retur Kembali</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Lainnya</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Penjualan</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Retur</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Buang</th>
                <th style="width: 10%;background-color:#151f48;color:white;text-align:center">Lainnya</th>
                <th bgcolor="orange" style="color:white;width: 8%;text-align:center">
                    <?php if (!empty($saldoawal['qtysaldoawal'])) {
                        echo number_format($saldoawal['qtysaldoawal']);
                    } ?>
            </tr>
        </thead>
        <tbody style="background-color: #a6cdd8;">
            <?php
            $saldoakhir    = $saldoawal['qtysaldoawal'];
            $qtypembelian       = 0;
            $qtyreturkembali    = 0;
            $qtymasuklainnya    = 0;
            $qtypenjualan       = 0;
            $qtyretur           = 0;
            $qtybuang           = 0;
            $qtykeluarlainnya   = 0;
            while (strtotime($dari) <= strtotime($sampai)) {

                $qpembelian           = "SELECT 
                pembelian_detail.kode_barang,
                SUM(qty) AS qtypembelian
                FROM pembelian_detail 
                INNER JOIN pembelian ON pembelian_detail.no_fak_pemb = pembelian.no_fak_pemb 
                WHERE tgl_transaksi = '$dari' AND pembelian_detail.kode_barang = '$kode_barang'
                GROUP BY pembelian.tgl_transaksi";
                $pembelian            = $this->db->query($qpembelian)->row_array();

                $qpenjualan           = "SELECT 
                penjualan_detail.kode_barang,
                SUM(qty) AS qtypenjualan
                FROM penjualan_detail 
                INNER JOIN penjualan ON penjualan_detail.no_fak_penj = penjualan.no_fak_penj 
                WHERE tgl_transaksi = '$dari' AND penjualan_detail.kode_barang = '$kode_barang'
                GROUP BY penjualan.tgl_transaksi";
                $penjualan            = $this->db->query($qpenjualan)->row_array();

                $qpemasukan           = "SELECT 
                pemasukan_detail.kode_barang,
                SUM( IF( pemasukan.jenis_pemasukan = 'Pengembalian Retur' , qty ,0 )) AS qtyreturkembali,
                SUM( IF( pemasukan.jenis_pemasukan = 'Lainnya' , qty ,0 )) AS qtymasuklainnya
                FROM pemasukan_detail 
                INNER JOIN pemasukan ON pemasukan_detail.no_pemasukan = pemasukan.no_pemasukan 
                WHERE tgl_transaksi = '$dari' AND pemasukan_detail.kode_barang = '$kode_barang'
                GROUP BY pemasukan.tgl_transaksi";
                $pemasukan            = $this->db->query($qpemasukan)->row_array();

                $qpengeluaran           = "SELECT 
                pengeluaran_detail.kode_barang,
                SUM( IF( pengeluaran.jenis_pengeluaran = 'Retur' , qty ,0 )) AS qtyretur,
                SUM( IF( pengeluaran.jenis_pengeluaran = 'Buang' , qty ,0 )) AS qtybuang,
                SUM( IF( pengeluaran.jenis_pengeluaran = 'Lainnya' , qty ,0 )) AS qtykeluarlainnya
                FROM pengeluaran_detail 
                INNER JOIN pengeluaran ON pengeluaran_detail.no_pengeluaran = pengeluaran.no_pengeluaran 
                WHERE tgl_transaksi = '$dari' AND pengeluaran_detail.kode_barang = '$kode_barang'
                GROUP BY pengeluaran.tgl_transaksi";
                $pengeluaran            = $this->db->query($qpengeluaran)->row_array();

                $qtymasuk    = $pembelian['qtypembelian'] + $pemasukan['qtyreturkembali'] + $pemasukan['qtymasuklainnya'];
                $qtykeluar   = $penjualan['qtypenjualan']  + $pengeluaran['qtyretur']  + $pengeluaran['qtybuang']  + $pengeluaran['qtylainnya'];
                $hasilqtyberat    = $qtymasuk - $qtykeluar;
                $saldoakhir  = $saldoakhir + $hasilqtyberat;

                $qtypembelian     += $pembelian['qtypembelian'];
                $qtyreturkembali  += $pemasukan['qtyreturkembali'];
                $qtymasuklainnya  += $pemasukan['qtymasuklainnya'];
                $qtypenjualan     += $penjualan['qtypenjualan'];
                $qtyretur         += $pengeluaran['qtyretur'];
                $qtybuang         += $pengeluaran['qtybuang'];
                $qtykeluarlainnya += $pengeluaran['qtykeluarlainnya'];

            ?>
                <tr style="color:black; font-size:14;">
                    <td style="color:white;background-color:teal"><?php echo $dari; ?></td>
                    <td align="center">
                        <?php
                        if (isset($pembelian['qtypembelian']) and $pembelian['qtypembelian'] != "0") {
                            echo number_format($pembelian['qtypembelian']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($pemasukan['qtyreturkembali']) and $pemasukan['qtyreturkembali'] != "0") {
                            echo number_format($pemasukan['qtyreturkembali']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($pemasukan['qtymasuklainnya']) and $pemasukan['qtymasuklainnya'] != "0") {
                            echo number_format($pemasukan['qtymasuklainnya']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($penjualan['qtypenjualan']) and $penjualan['qtypenjualan'] != "0") {
                            echo number_format($penjualan['qtypenjualan']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($pengeluaran['qtyretur']) and $pengeluaran['qtyretur'] != "0") {
                            echo number_format($pengeluaran['qtyretur']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($pengeluaran['qtybuang']) and $pengeluaran['qtybuang'] != "0") {
                            echo number_format($pengeluaran['qtybuang']);
                        }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        if (isset($pengeluaran['qtykeluarlainnya']) and $pengeluaran['qtykeluarlainnya'] != "0") {
                            echo number_format($pengeluaran['qtykeluarlainnya']);
                        }
                        ?>
                    </td>
                    <td align="center" style="color:white;background-color:teal">
                        <?php
                        if (isset($saldoakhir) and $saldoakhir != "0") {
                            echo number_format($saldoakhir);
                        }
                        ?>
                    </td>
                </tr>
            <?php
                $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: center;background-color:#0085cd;color:white">Total</th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtypembelian);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtyreturkembali);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtymasuklainnya);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtypenjualan);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtyretur);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtybuang);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($qtykeluarlainnya);?></th>
                <th style="text-align: center;background-color:#0085cd;color:white"><?php echo number_format($saldoakhir);?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>