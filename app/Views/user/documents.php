<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Dokumen Kegiatan <?= isset($_GET['pak']) ? 'PAK' : 'Harmonisasi'; ?></title>
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
                        <p class="fs-3 fw-normal m-0">Dokumen Acara</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/user/projects">Kegiatan</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/user/projects/detail?id=<?= $_GET['p']; ?>">Acara</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dokumen Acara</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3">
                                    <p class="m-0"><i class="fa-solid fa-folder-open"></i> &nbsp;<?= $event[0]['name']; ?></p>
                                </div>
                                <div class="card-body p-2 p-sm-3">
                                    <h6>Catatan / Deskripsi Acara</h6>
                                    <p><?= $event[0]['description']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">

                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <table class="table" id="table-document">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>Pengunggah</th>
                                            <th>Waktu Pengunggahan</th>
                                            <th>Opsi</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($eventfiles as $key => $file) {
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $file['document_name']; ?></td>
                                                    <td><?= $file['uploader']; ?></td>
                                                    <td><?= date_format(date_create($file['upload_time']), "d-m-Y H:i A"); ?></td>
                                                    <td>
                                                        <a target="_blank" href="<?= base_url() ?>/admin/projects/events/download?filename=<?= $file['file_name']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-download"></i> Unduh</a>
                                                        <?php if ($file['user_id'] == $userData['id']) {
                                                        ?>
                                                            <a href="<?= base_url() ?>/admin/projects/events/delete?u=true&filename=<?= $file['file_name']; ?>&e=<?= $event[0]['id']; ?>&p=<?= $_GET['p']; ?>" class=" btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                                                        <?php
                                                        } ?>
                                                    </td>
                                                </tr>

                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        <form action="<?= base_url() ?>/admin/projects/eventdocs/upload" method="POST" enctype="multipart/form-data">
                                            <input type="text" name="u" value="true>" hidden>
                                            <input type="text" name="event_id" value="<?= $_GET['e']; ?>" hidden>
                                            <input type="text" name="project_id" value="<?= $_GET['p']; ?>" hidden>
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

    <!-- Notiflix -->
    <script src="<?= base_url('public/assets') ?>/js/notiflix-aio-3.2.5.min.js"></script>

    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var t = $('#table-document').DataTable({
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

        });
        Notiflix.Confirm.init({
            borderRadius: '10px',
            titleColor: '#417230',
            okButtonBackground: '#417230',
        })
    </script>
</body>

</html>