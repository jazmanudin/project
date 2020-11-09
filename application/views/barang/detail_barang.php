<style>
    th {
        background-color: #0085cd;
        color: white;
    }
</style>
<table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th style="width: 170px;">Kode Barang</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['kode_barang']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Nama Barang</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['nama_barang']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Satuan Barang</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['satuan']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Harga Modal</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['harga_modal']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Pel. Tetap</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['pelanggan_tetap']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Pel. Tidak Tetap</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['tidak_tetap']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Eceran</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['eceran']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Grosir</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['grosir']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Lainnya</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['lainnya']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Diskon</th>
            <td style="width: 10px;">:</td>
            <td><?php echo number_format($detail['diskon']); ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Kategori</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['kode_kategori']; ?></td>
        </tr>
        <!-- <tr>
            <th style="width: 170px;">Jenis Barang</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['jenis_barang']; ?></td>
        </tr> -->
        <tr>
            <th style="width: 170px;">Keterangan</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['keterangan']; ?></td>
        </tr>
    </thead>
</table>