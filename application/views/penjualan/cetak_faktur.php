<?php


?>
<style>
    body {
        letter-spacing: 0px;
        font-family: Calibri;
        font-size: 14px;
    }

    table {
        font-family: Tahoma;
        font-size: 14px;
    }

    .garis5,
    .garis5 td,
    .garis5 tr,
    .garis5 th {
        border: 2px solid black;
        border-collapse: collapse;
    }

    .table {
        border: solid 1px #000000;
        width: 100%;
        font-size: 12px;
        margin: auto;
    }

    .table th {
        border: 1px #000000;
        font-size: 12px;

        font-family: Arial;
    }

    .table td {
        border: solid 1px #000000;
    }
</style>
<title>CETAK FAKTUR</title>
<table border="0" width="100%">
    <tr>
        <td style="width:150px">
            <table class="garis5">
                <tr>
                    <td>FAKTUR</td>
                </tr>
                <tr>
                    <td>NOMOR <?php echo $faktur['no_fak_penj'] ?></td>

                </tr>
            </table>
        </td>
        <?php 
        $kode_perusahaan = $this->session->userdata("id_member");
        $perusahaan  = $this->db->query("SELECT * FROM perusahaan WHERE kode_perusahaan = '$kode_perusahaan' ")->row_array(); ?>
        <td colspan="6" align="left">
            <b><?php echo $perusahaan['nama_perusahaan'];?><br>
            <?php echo $perusahaan['alamat'];?>
            </b>
        </td>
    </tr>
    <tr>
        <td colspan="7" align="center">
            <hr>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td width="15%">Tgl Faktur</td>
        <td width="1%">:</td>
        <td width="40%"><?php echo DatetoIndo2($faktur['tgl_transaksi']); ?></td>
        <td>Nama Customer</td>
        <td>:</td>
        <td><?php echo $faktur['nama_pelanggan']; ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $faktur['alamat']; ?></td>
    </tr>

    <tr>
        <td colspan="7">

            <table class="garis5" width="100%">
                <thead>
                    <tr>
                        <th style="width:10%">KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th style="width:6%">SATUAN</th>
                        <th>KETERANGAN</th>
                        <th style="width:10%">HARGA</th>
                        <th style="width:5%">JUMLAH</th>
                        <th style="width:10%">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($data as $d) {
                        $total += $d->qty * $d->harga_jual;
                    ?>
                        <tr>
                            <td><?php echo $d->kode_barang; ?></td>
                            <td><?php echo $d->nama_barang; ?></td>
                            <td><?php echo $d->satuan; ?></td>
                            <td><?php echo $d->keterangan; ?></td>
                            <td align="right"><?php echo number_format($d->harga_jual); ?></td>
                            <td align="center"><?php echo number_format($d->qty); ?></td>
                            <td align="right"><?php echo number_format($d->harga_jual * $d->qty); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6" align="center">Jumlah</td>
                        <td align="right"><?php echo number_format($faktur['total'], '0', '', '.'); ?>
                    </tr>
                    <tr>
                        <td colspan="6" align="center">Diskon</td>
                        <td align="right"><?php echo number_format($faktur['potongan'], '0', '', '.'); ?>
                    </tr>
                    <tr>
                        <td colspan="6" align="center">Total Pembayaran</td>
                        <td align="right"><?php echo number_format($faktur['jumlahbayar'], '0', '', '.'); ?>
                    </tr>
                </tbody>

            </table>

        </td>
    </tr>

</table>

<div style="page-break-before:always;">