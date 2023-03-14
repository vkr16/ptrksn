<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Daftar Kehadiran </title>
    <link rel="shortcut icon" href="<?= base_url('public/assets/img') ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets') ?>/css/main.css" />

</head>


</head>

<body>

    <div class="mx-2" id="printbody">
        <div class="mt-3" style="height:80px">
            <img src="<?= base_url('public/assets/img') ?>/logo-banner-dark.png" style="height:80px" alt="">
        </div>
        <hr>
        <p class="fs-5 fw-semibold">Dokumen Rekapitulasi Daftar Kehadiran</p>
        <table>
            <tr>
                <td>Kegiatan</td>
                <td>: <?= $meeting[0]['name']; ?></td>
            </tr>
            <tr>
                <td>Waktu Pelaksanaan &nbsp; </td>
                <td>: <?= date_format(date_create($meeting[0]['datetime']), "d-m-Y H:i A"); ?></td>
            </tr>
        </table>

        <br><br>
        <table class="table">
            <thead>
                <th>No.</th>
                <th>Nama Partisipan</th>
                <th>NIP</th>
                <th>NIK</th>
                <th>Jabatan</th>
                <th>Instansi Asal</th>
                <th>Tanda Tangan</th>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($attendances as $key => $attendance) { ?>
                    <tr>
                        <td class="align-middle"><?= $i; ?></td>
                        <td class="align-middle"><?= $attendance['name']; ?></td>
                        <td class="align-middle"><?= $attendance['nip']; ?></td>
                        <td class="align-middle"><?= $attendance['nik']; ?></td>
                        <td class="align-middle"><?= $attendance['position']; ?></td>
                        <td class="align-middle"><?= $attendance['instance']; ?></td>
                        <td class="align-middle"><img src="<?= $attendance['signature']; ?>" style="height:50px"></td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
        <br><br>

        <small class="text-muted">Dokumen ini dicetak pada : <?= date_format(date_create('now'), "d-m-Y H:i A") ?></small>

    </div>
    <style>
        tr {
            page-break-inside: avoid;
        }
    </style>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/e4b7aab4db.js" crossorigin="anonymous"></script>

    <!-- JQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- HTML2PDF -->
    <script src="<?= base_url('public/assets') ?>/js/html2pdf/html2pdf.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            print();
        });
    </script>

</body>

</html>