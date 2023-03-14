<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Detail Kegiatan</title>
    <link rel="shortcut icon" href="<?= base_url('public/assets/img') ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets') ?>/css/main.css" />

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/byl4oikuvknydm7bl5aijyvsqxt16dkq9z0mtj35dibykwna/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.tinymce',
            plugins: [
                'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help'
        })
        tinymce.init({
            selector: 'textarea#comment',
            menubar: false,
            toolbar: 'undo redo | bold italic backcolor |',
            height: 200
        })
    </script>
</head>


</head>

<body>
    <div class="d-flex">
        <?= $this->include('layout_components/sidebar-user'); ?>
        <section class="vh-100 w-100 scrollable-y">
            <?= $this->include('layout_components/topbar'); ?>
            <div class="w-100">
                <div class="container-fluid">
                    <div class="col-md-12 d-flex justify-content-between align-items-center p-3 my-2">
                        <p class="fs-3 fw-normal m-0">Detail Kegiatan</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Pengguna</li>
                                <li class="breadcrumb-item">Kegiatan</li>
                                <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Card Panels -->
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-diagram-project"></i> &nbsp; Informasi Kegiatan</p>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">

                                        <p class="fw-semibold m-0 p-0 " id="name">
                                            <span id="name-static"><?= $project['name']; ?></span>
                                        </p>
                                        <hr>
                                        <p class="fw-normal m-0 p-0 " id="description">
                                            <span id="description-static"><?= $project['description']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3">
                                    <p class="m-0"><i class="fa-solid fa-calendar-day"></i> &nbsp; Daftar Acara</p>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <table class="table" id="table-event">
                                            <thead>
                                                <th>No</th>
                                                <th>Nama Agenda</th>
                                                <th>Waktu Pelaksanaan</th>
                                                <th>Dokumen</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($events as $key => $event) {
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $event['name']; ?></td>
                                                        <td><?= date_format(date_create($event['commit_time']), "d-m-Y"); ?></td>
                                                        <td>
                                                            <a href="<?= base_url() ?>/user/projects/event?p=<?= $project['id']; ?>&e=<?= $event['id']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-folder"></i>&nbsp; Lihat Dokumen</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3">
                                    <p class="m-0"><i class="fa-solid fa-folder-open"></i> &nbsp; Berkas Kegiatan</p>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <table class="table">
                                            <thead>
                                                <th>No</th>
                                                <th>Nama Berkas</th>
                                                <th>Pengunggah</th>
                                                <th>Diunggah Pada</th>
                                                <th>Opsi</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($files as $key => $file) {
                                                ?>
                                                    <tr>
                                                        <td><?= $key + 1; ?></td>
                                                        <td><?= $file['document_name']; ?></td>
                                                        <td><?= $file['uploader']; ?></td>
                                                        <td><?= date_format(date_create($file['upload_time']), "d/m/Y H:i A"); ?></td>
                                                        <td>
                                                            <a target="_blank" href="<?= base_url() ?>/user/projects/download?filename=<?= $file['file_name']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-download"></i> Unduh</a>
                                                            <?php if ($file['user_id'] == $userData['id']) {
                                                            ?>
                                                                <a href="<?= base_url() ?>/admin/projects/delete?u=true&filename=<?= $file['file_name']; ?>&id=<?= $project['id']; ?>" class=" btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                                                            <?php
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2">
                                        <form action="<?= base_url() ?>/user/projects/upload" method="POST" enctype="multipart/form-data">
                                            <input type="text" name="project_id" value="<?= $project['id']; ?>" hidden>
                                            <input type="text" name="user_id" value="<?= $userData['id']; ?>" hidden>
                                            <div class="input-group">
                                                <input required type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" name="file2upload" aria-label="Upload">
                                                <button class="btn btn-green" type="submit" id="inputGroupFileAddon04">Unggah</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3">
                                    <p class="m-0"><i class="fa-solid fa-comments"></i> &nbsp; Komentar</p>
                                </div>
                                <div class="card-body p-2 p-sm-3">
                                    <div class="d-flex p-1" style="max-height: 60vh; overflow-y: auto; flex-direction: column-reverse;">
                                        <?php foreach ($commentData as $key => $comment) {
                                        ?>
                                            <div class="p-2 border rounded mb-3">
                                                <p class="fw-semibold"><?= $comment['user']; ?> &emsp; <span class="fw-normal fs-6"><?= date_format(date_create($comment['commented_at']), "d/m/Y H:i A"); ?> </span> </p>
                                                <p class="mb-0"><?= $comment['comment']; ?></p>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div>
                                        <hr>
                                        <form action="<?= base_url() ?>/user/projects/addComment" method="POST">

                                            <input type="text" name="userid" hidden value="<?= $userData['id']; ?>">
                                            <input type="text" name="id" hidden value="<?= $project['id']; ?>">
                                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                                            <button class="btn btn-green mt-3"><i class="fa-solid fa-comment"></i>&nbsp; Send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/e4b7aab4db.js" crossorigin="anonymous"></script>

    <!-- JQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var t = $('#myTable').DataTable();
            t.on('order.dt search.dt', function() {
                let i = 1;

                t.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

            var r = $('#table-event').DataTable({
                "language": {
                    "search": "Cari : ",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan.",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data tidak tersedia",
                    "infoFiltered": "(Difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": '<i class="fa-solid fa-angle-right"></i>',
                        "previous": '<i class="fa-solid fa-angle-left"></i>'
                    },
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0,
                }, ],
                "order": [
                    [1, 'asc']
                ],
            });

            r.on('order.dt search.dt', function() {
                let i = 1;

                r.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        });

        function editMode() {
            $('#name-static').hide()
            $('#description-static').hide()
            $('#progress-static').hide()
            $('#trigger-open').hide()
            tinymce.get("descriptionedit").setContent($('#description-static').html())

            $('#name-edit').show()
            $('#description-edit').show()
            $('#progress-edit').show()
            $('#btn-submitEdit').show()
            $('#trigger-close').show()
        }

        function viewMode() {
            $('#name-static').show()
            $('#description-static').show()
            $('#progress-static').show()
            $('#trigger-open').show()

            $('#name-edit').hide()
            $('#description-edit').hide()
            $('#progress-edit').hide()
            $('#btn-submitEdit').hide()
            $('#trigger-close').hide()
        }
    </script>
</body>

</html>