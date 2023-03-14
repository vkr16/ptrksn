<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Daftar Kehadiran </title>
    <link rel="shortcut icon" href="<?= IMAGES_URL ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css" />

</head>


</head>

<body>

    <div class="mx-2" id="printbody">
        <div class="mt-3 d-flex justify-content-between align-items-center" style="height:80px">
            <img src="<?= IMAGES_URL ?>/logo-banner-dark.png" style="height:80px" alt="">
        </div>
        <hr>
        <p class="fs-5 fw-normal text-center">DOKUMEN REKAPITULASI KEGIATAN</p>

        <table>
            <tr>
                <td>Nama Kegiatan</td>
                <td>: <?= $project['name']; ?></td>
            </tr>
            <tr>
                <td>Status Kemajuan &nbsp; </td>
                <td>: <?= $lastevent == null ? 'Belum ada pekerjaan' : $lastevent[0]['name']; ?></td>
            </tr>
        </table>

        <div class="card border-secondary mt-3">
            <div class="card-header">
                <p class="">Deskripsi Kegiatan</p>
            </div>
            <div class="card-body">
                <?= $project['description']; ?>
            </div>
        </div>
        <hr>

        <h4>Dokumen Kegiatan</h4>
        <table class="table">
            <thead>
                <th>No</th>
                <th>Nama File</th>
                <th>Pengunggah</th>
                <th>Instansi Asal</th>
                <th>Waktu Pengunggahan</th>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($files as $key => $file) { ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $file['document_name']; ?></td>
                        <td><?= $file['uploader']; ?></td>
                        <td><?= $file['instance']; ?></td>
                        <td><?= date_format(date_create($file['upload_time']), 'd/m/Y H:i A'); ?></td>
                    </tr>

                <?php $i++;
                } ?>
            </tbody>
        </table>

        <br>
        <hr><br>
        <?php foreach ($events as $index => $event) {
        ?>



            <table>
                <tr>
                    <td>Nama Acara </td>
                    <td>: <?= $event['name']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pelaksanaan &nbsp;</td>
                    <td>: <?= date_format(date_create($event['commit_time']), 'd/m/Y'); ?></td>
                </tr>
            </table>


            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Pengunggah</th>
                    <th>Instansi Asal</th>
                    <th>Waktu Pengunggahan</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($eventfiles[$index] as $key => $file) {

                    ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $file['document_name']; ?></td>
                            <td><?= $file['uploader']; ?></td>
                            <td><?= $file['instance']; ?></td>
                            <td><?= date_format(date_create($file['upload_time']), 'd/m/Y H:i A'); ?></td>




                        </tr>

                    <?php
                    } ?>
                </tbody>
            </table>

            <br>

        <?php
        } ?>


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
    <script src="<?= ASSETS_URL ?>/js/html2pdf/html2pdf.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            print();
        });
    </script>

</body>

</html>