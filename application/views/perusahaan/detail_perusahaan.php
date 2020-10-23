<style>
    th {
        background-color: #0085cd;
        color: white;
    }
</style>
<table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th style="width: 170px;">Kode Perusahaan</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['kode_perusahaan']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Nama Perusahaan</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['nama_perusahaan']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Alamat Perusahaan</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['alamat']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Provinsi</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['provinsi']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Kota</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['kota']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Kecamatan</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['kecamatan']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Desa</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['desa']; ?></td>
        </tr>
        </tr>
        <tr>
            <th style="width: 170px;">No HP</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['no_hp']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Email</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['email']; ?></td>
        </tr>
        <tr>
            <th style="width: 170px;">Exp Date</th>
            <td style="width: 10px;">:</td>
            <td><?php echo $detail['exp_date']; ?></td>
        </tr>
    </thead>
</table>