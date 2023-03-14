<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Detail Kegiatan</title>
    <link rel="shortcut icon" href="<?= base_url('public/assets/img') ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!-- Datepicker -->
    <link rel="stylesheet" href="<?= base_url('public/assets') ?>/css/bootstrap-datepicker3.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets') ?>/css/main.css" />

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/byl4oikuvknydm7bl5aijyvsqxt16dkq9z0mtj35dibykwna/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.tinymce',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
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
        <?= $this->include('layout_components/sidebar'); ?>
        <section class="vh-100 w-100 scrollable-y">
            <?= $this->include('layout_components/topbar'); ?>
            <div class="w-100">
                <div class="container-fluid">
                    <div class="col-md-12 d-flex justify-content-between align-items-center p-3 my-2">
                        <p class="fs-3 fw-normal m-0">Detail Kegiatan</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin/projects">Kegiatan</a></li>
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
                                    <span>
                                        <a href="detail/topdf?id=<?= $project['id']; ?>" id="printButton" class="btn btn-sm btn-light"><i class="fa-solid fa-print"></i>&nbsp; Cetak / Ekspor PDF</a>
                                        <button id="deleteProjectButton" class="btn btn-sm btn-warning" onclick="deletePrompt(<?= $project['id']; ?>)"><i class="fa-solid fa-trash-alt"></i>&nbsp; Hapus Kegiatan</button>
                                        <button id="trigger-open" class="btn btn-sm btn-light" onclick="editMode()"><i class="fa-solid fa-file-pen"></i>&nbsp; Mode Edit</button>
                                        <button id="trigger-close" class="btn btn-sm btn-light" onclick="viewMode()" style="display: none"><i class="fa-solid fa-glasses"></i>&nbsp; Mode Baca</button>
                                    </span>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">

                                        <form action="<?= base_url() ?>/admin/projects/update" method="POST">
                                            <input type="text" name="project_id" hidden value="<?= $project['id']; ?>">
                                            <p class="fw-semibold m-0 p-0 " id="name">
                                                <span id="name-static"><?= $project['name']; ?></span>
                                                <span id="name-edit" style="display: none">
                                                    <input type="text" name="name" class="form-control" placeholder="Project Name" value="<?= $project['name']; ?>">
                                                </span>
                                            </p>
                                            <hr>
                                            <p class="fw-normal m-0 p-0 " id="description">
                                                <span id="description-static"><?= $project['description']; ?></span>
                                                <span id="description-edit" style="display: none;">
                                                    <textarea name="description" id="descriptionedit" class="tinymce" cols="30" rows="10"></textarea>
                                                </span>
                                            </p>

                                            <button class="btn btn-green mt-3" id="btn-submitEdit" style="display: none">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-calendar-day"></i> &nbsp; Daftar Acara</p>
                                    <span>
                                        <button class="btn btn-sm btn-light" onclick="newEvent(<?= $_GET['id']; ?>)"><i class="fa-solid fa-plus"></i>&nbsp; Tambah Acara</button>
                                    </span>
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
                                                        <td class="d-flex justify-content-between align-items-center">
                                                            <a href="<?= base_url() ?>/admin/projects/event?p=<?= $project['id']; ?>&e=<?= $event['id']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-folder"></i>&nbsp; Lihat Dokumen</a>
                                                            <div class="dropdown me-4 mt-1">
                                                                <button class="btn btn-sm" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a role="button" class="dropdown-item" onclick="editEvent(<?= $_GET['id']; ?>,<?= $event['id']; ?>,'<?= $event['name']; ?>','<?= date_format(date_create($event['commit_time']), 'd-m-Y') ?>','<?= $event['description']; ?>')"><i class="fa-solid fa-pen"></i> &nbsp;Ubah</a></li>
                                                                    <li><a role="button" class="dropdown-item" onclick="deleteEvent(<?= $event['id']; ?>,<?= $_GET['id']; ?>)"><i class="fa-solid fa-trash-alt"></i> &nbsp;Hapus</a></li>
                                                                </ul>
                                                            </div>
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
                                    <p class="m-0"><i class="fa-solid fa-folder-open"></i> &nbsp; Dokumen Kegiatan</p>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <table class="table" id="table-dokumen">
                                            <thead>
                                                <th>No</th>
                                                <th>Nama Berkas</th>
                                                <th>Pengunggah</th>
                                                <th>Waktu Pengunggahan</th>
                                                <th>Opsi</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($files as $key => $file) {
                                                ?>
                                                    <tr>
                                                        <td><?= $key + 1; ?></td>
                                                        <td><?= $file['document_name']; ?></td>
                                                        <td><?= $file['uploader']; ?></td>
                                                        <td><?= date_format(date_create($file['upload_time']), "d-m-Y H:i A"); ?></td>
                                                        <td>
                                                            <a href="<?= base_url() ?>/admin/projects/delete?filename=<?= $file['file_name']; ?>&id=<?= $project['id']; ?>" class=" btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                                                            <a target="_blank" href="<?= base_url() ?>/admin/projects/download?filename=<?= $file['file_name']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-download"></i> Unduh</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2">
                                        <form action="<?= base_url() ?>/admin/projects/upload" method="POST" enctype="multipart/form-data">
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
                    <div class="container-fluid mt-3 row mx-0 px-0" id="comments">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3">
                                    <p class="m-0"><i class="fa-solid fa-comments"></i> &nbsp; Komentar</p>
                                </div>
                                <div class="card-body p-2 p-sm-3">
                                    <div class="d-flex" style="max-height: 60vh; overflow-y: auto; flex-direction: column-reverse;">
                                        <?php foreach ($commentData as $key => $comment) {
                                        ?>
                                            <div class="p-2 border rounded mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-semibold"><?= $comment['user']; ?> &emsp; <span class="fw-normal fs-6"><?= date_format(date_create($comment['commented_at']), "d/m/Y H:i A"); ?> </span>
                                                    <div class="dropdown me-4 bg-light mt-1">
                                                        <button class="btn" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" onclick="deleteComment(<?= $comment['id']; ?>,'<?= $comment['user']; ?>')">Delete Comment</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                </p>

                                                <p class="mb-0"><?= $comment['comment']; ?></p>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div>
                                        <hr>
                                        <form action="<?= base_url() ?>/admin/projects/addComment" method="POST">

                                            <input type="text" name="userid" hidden value="<?= $userData['id']; ?>">
                                            <input type="text" name="id" hidden value="<?= $project['id']; ?>">
                                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                                            <button class="btn btn-green mt-3"><i class="fa-solid fa-comment"></i>&nbsp; Kirim Komentar</button>
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




    <div class="modal fade" id="modalNewEvent" tabindex="-1" aria-labelledby="modalNewEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="addEvent" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNewEventLabel">Tambah Agenda Acara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="hidden-projid" name="project_id" hidden>
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Nama Kegiatan</label>
                            <input required type="text" class="form-control" id="eventName" name="eventName" placeholder="Nama Kegiatan">
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Tanggal Pelaksanaan</label>
                            <input required type="text" class="form-control" name="eventDate" id="eventDate" readonly placeholder="Tanggal Pelaksanaan" />
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Deskripsi Kegiatan</label>
                            <textarea required class="form-control" id="eventDescription" name="eventDescription" placeholder="Deskripsi Kegiatan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditAcara" tabindex="-1" aria-labelledby="modalEditAcaraLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="editEvent" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNewEventLabel">Edit Detail Agenda Acara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="hidden-projid" name="project_id" hidden>
                        <input type="text" class="hidden-eventid" name="event_id" hidden>
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Nama Kegiatan</label>
                            <input required type="text" class="form-control" id="eventName2" name="eventName" placeholder="Nama Kegiatan">
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Tanggal Pelaksanaan</label>
                            <input required type="text" class="form-control" name="eventDate" id="eventDate2" readonly placeholder="Tanggal Pelaksanaan" />
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Deskripsi Kegiatan</label>
                            <textarea required class="form-control" id="eventDescription2" name="eventDescription" placeholder="Deskripsi Kegiatan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/e4b7aab4db.js" crossorigin="anonymous"></script>

    <!-- JQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Notiflix -->
    <script src="<?= base_url('public/assets') ?>/js/notiflix-aio-3.2.5.min.js"></script>

    <!-- Datepicker -->
    <script src="<?= base_url('public/assets') ?>/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url('public/assets') ?>/js/bootstrap-datepicker.id.min.js"></script>

    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#eventDate").datepicker({
                format: "dd-mm-yyyy",
                startView: "days",
                minViewMode: "days",
                language: 'id'
            });
            $("#eventDate2").datepicker({
                format: "dd-mm-yyyy",
                startView: "days",
                minViewMode: "days",
                language: 'id'
            });


            var t = $('#table-dokumen').DataTable({
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

            t.on('order.dt search.dt', function() {
                let i = 1;

                t.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

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
        Notiflix.Confirm.init({
            borderRadius: '10px',
            titleColor: '#417230',
            okButtonBackground: '#417230',
        })

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

        function deleteComment(commentid, by) {

            Notiflix.Confirm.show(
                'Hapus komentar ',
                'Hapus komentar oleh' + by + '?',
                'Ya',
                'Batal',
                () => {
                    $.post("comments/delete", {
                            id: commentid
                        })
                        .done(function(data) {
                            Notiflix.Notify.success("Dihapus!");

                            setTimeout(function() {
                                window.location.reload()
                            }, 1000);
                        });
                },
                () => {}, {},
            );
        }

        function deletePrompt(id) {
            Notiflix.Confirm.show(
                'Hapus Kegiatan?',
                'Menghapus kegiatan akan menghapus seluruh dokumen dan komentar terkait kegiatan ini?',
                'Hapus',
                'Batal',
                () => {
                    $.post("purge", {
                            id: id
                        })
                        .done(function(data) {
                            Notiflix.Notify.success("Dihapus!");

                            setTimeout(function() {
                                window.location.replace('../')
                            }, 1000);
                        });
                },
                () => {}, {},
            );
        }

        function newEvent(project_id) {
            $("#modalNewEvent").modal('show')
            $('.hidden-projid').val(project_id)
        }

        function editEvent(project_id, event_id, name, date, desc) {
            $("#modalEditAcara").modal('show')
            $('.hidden-projid').val(project_id)
            $('.hidden-eventid').val(event_id)
            $("#eventName2").val(name)
            $("#eventDate2").val(date)
            $("#eventDescription2").val(desc)
        }

        function deleteEvent(event_id, project_id) {
            Notiflix.Confirm.show(
                'Hapus Agenda Acara ',
                'Menghapus agenda ini akan menghapus seluruh dokumen yang diunggah didalamnya. Lanjutkan?',
                'Ya',
                'Batal',
                () => {
                    $.post("event/purge", {
                            event_id: event_id,
                            project_id: project_id,
                        })
                        .done(function(data) {
                            if (data == 'ok') {
                                Notiflix.Notify.success("Dihapus!");

                                setTimeout(function() {
                                    window.location.reload()
                                }, 1000);
                            } else {
                                Notiflix.Notify.failure("Gagal!");

                                setTimeout(function() {
                                    window.location.reload()
                                }, 1000);
                            }
                        });
                },
                () => {}, {},
            );
        }
    </script>
</body>

</html>