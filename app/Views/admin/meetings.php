<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Daftar Pertemuan </title>
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
        <?= $this->include('layout_components/sidebar'); ?>
        <section class="vh-100 w-100 scrollable-y">
            <?= $this->include('layout_components/topbar'); ?>
            <div class="w-100">
                <div class="container-fluid">
                    <div class="col-md-12 d-flex justify-content-between align-items-center p-3 my-2">
                        <p class="fs-3 fw-normal m-0">Daftar Hadir</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active" aria-current="page">Daftar Pertemuan</li>
                            </ol>
                        </nav>
                    </div>


                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-clipboard-check"></i> &nbsp; Daftar Hadir</p>
                                    <span>
                                        <button class="btn btn-sm btn-light" onclick="newAgenda()"><i class="fa-solid fa-plus"></i> &nbsp;Buat Agenda</button>
                                    </span>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <table class="table" id="table-meetings">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama Agenda</th>
                                            <th>Waktu Pelaksanaan</th>
                                            <th>Status</th>
                                            <th>Hadir</th>
                                            <th>Daftar Hadir</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($meetings as $key => $meeting) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $meeting['name']; ?></td>
                                                    <td><?= date_format(date_create($meeting['datetime']), "d-m-Y H:i A"); ?></td>
                                                    <td><?= $meeting['status'] == 'closed' ? '<i class="fa-solid fa-circle text-secondary"></i>&nbsp; Ditutup' : '<i class="fa-solid fa-circle text-success"></i>&nbsp; Terbuka'; ?></td>
                                                    <td><?= $attendance[$key]; ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-between align-items-center ">
                                                            <a href="meetings/attendance?m=<?= $meeting['id']; ?>" class="btn btn-sm btn-green"><i class="fa-solid fa-list-check"></i> &nbsp;Lihat Daftar</a>
                                                            <div class="dropdown me-4 mt-1">
                                                                <button class="btn btn-sm" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a role="button" class="dropdown-item" onclick="updateMeeting(
                                                                        <?= $meeting['id']; ?>,
                                                                        '<?= $meeting['name']; ?>',
                                                                        '<?= date_format(date_create($meeting['datetime']), 'd-m-Y'); ?>',
                                                                        '<?= date_format(date_create($meeting['datetime']), 'H'); ?>',
                                                                        '<?= date_format(date_create($meeting['datetime']), 'i'); ?>'
                                                                        )"><i class="fa-solid fa-pencil"></i> &nbsp;Ubah</a></li>
                                                                    <li><a role="button" class="dropdown-item" onclick="deleteMeeting(<?= $meeting['id']; ?>)"><i class="fa-solid fa-trash-alt"></i> &nbsp;Hapus</a></li>
                                                                </ul>
                                                            </div>
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
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalNewAgenda" tabindex="-1" aria-labelledby="modalNewAgendaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="meetings/addMeeting" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNewAgendaLabel">Buat Agenda Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="agendaName" class="form-label">Nama Agenda</label>
                            <input required type="text" class="form-control" id="agendaName" name="agendaName" placeholder="Nama Agenda">
                        </div>
                        <div class="mb-3">
                            <label for="agendaDate" class="form-label">Waktu Pelaksanaan</label>
                            <div class="mb-3 row mx-0 px-0">
                                <div class="col-sm-5 mx-0 px-0">
                                    <input required type="text" class="form-control" id="agendaDate" name="agendaDate" value="<?= date_format(date_create('now'), "d-m-Y"); ?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <select required name="hour" class="form-select col-6" id="hr">
                                        <?php for ($i = 0; $i < 24; $i++) {
                                        ?>
                                            <option value="<?= $i < 10 ? '0' . $i : $i; ?>"><?= $i < 10 ? '0' . $i : $i; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1 d-flex justify-content-center align-items-center">
                                    <h3>:</h3>
                                </div>
                                <div class="col-sm-3 me-0 pe-0">
                                    <select required name="minute" class="form-select col-6" id="min">
                                        <?php for ($i = 0; $i < 60; $i++) {
                                        ?>
                                            <option value="<?= $i < 10 ? '0' . $i : $i; ?>"><?= $i < 10 ? '0' . $i : $i; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
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
    <div class="modal fade" id="modalEditAgenda" tabindex="-1" aria-labelledby="modalEditAgendaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="meetings/editMeeting" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditAgendaLabel">Buat Agenda Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="mid" id="mid-hidden" hidden>
                        <div class="mb-3">
                            <label for="agendaName" class="form-label">Nama Agenda</label>
                            <input required type="text" class="form-control" id="agendaName2" name="agendaName" placeholder="Nama Agenda">
                        </div>
                        <div class="mb-3">
                            <label for="agendaDate" class="form-label">Waktu Pelaksanaan</label>
                            <div class="mb-3 row mx-0 px-0">
                                <div class="col-sm-5 mx-0 px-0">
                                    <input required type="text" class="form-control" id="agendaDate2" name="agendaDate" value="<?= date_format(date_create('now'), "d-m-Y"); ?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <select required name="hour" class="form-select col-6" id="hr2">
                                        <?php for ($i = 0; $i < 24; $i++) {
                                        ?>
                                            <option value="<?= $i < 10 ? '0' . $i : $i; ?>"><?= $i < 10 ? '0' . $i : $i; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1 d-flex justify-content-center align-items-center">
                                    <h3>:</h3>
                                </div>
                                <div class="col-sm-3 me-0 pe-0">
                                    <select required name="minute" class="form-select col-6" id="min2">
                                        <?php for ($i = 0; $i < 60; $i++) {
                                        ?>
                                            <option value="<?= $i < 10 ? '0' . $i : $i; ?>"><?= $i < 10 ? '0' . $i : $i; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
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

    <!-- Datepicker -->
    <script src="<?= base_url('public/assets') ?>/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url('public/assets') ?>/js/bootstrap-datepicker.id.min.js"></script>

    <!-- Notiflix -->
    <script src="<?= base_url('public/assets') ?>/js/notiflix-aio-3.2.5.min.js"></script>

    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script>
        $('#sidebar-item-meetings').removeClass('sidebar-item').addClass('sidebar-active');
        $('#sidebar-item-projects').removeClass('sidebar-active').addClass('sidebar-item');
        $(document).ready(function() {

            $("#agendaDate").datepicker({
                format: "dd-mm-yyyy",
                startView: "days",
                minViewMode: "days",
                language: 'id'
            });
            $("#agendaDate2").datepicker({
                format: "dd-mm-yyyy",
                startView: "days",
                minViewMode: "days",
                language: 'id'
            });

            var t = $('#table-meetings').DataTable({
                "ordering": false,
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

        function newAgenda() {
            $('#modalNewAgenda').modal('show')
            var now = new Date()
            var hr = now.getHours()
            var min = now.getMinutes()
            if (hr < 10) {
                hr = "0" + hr;
            }
            if (min < 10) {
                min = "0" + min;
            }
            $('#hr').val(hr).change();
            $('#min').val(min).change();
        }

        function deleteMeeting(mid) {
            Notiflix.Confirm.show(
                'Batalkan Pertemuan',
                'Seluruh data kehadiran yang sudah tercatat akan dihapus',
                'Lanjutkan',
                'Batal',
                () => {
                    $.post("meetings/delete", {
                            meeting_id: mid
                        })
                        .done(function(data) {
                            if (data == "ok") {
                                Notiflix.Notify.success("Pertemuan Dibatalkan!")
                                setTimeout(function() {
                                    window.location.reload()
                                }, 1000);
                            } else {
                                Notiflix.Notify.failure("Gagal!")
                                setTimeout(function() {
                                    window.location.reload()
                                }, 1000);
                            }
                        });
                },
                () => {}, {},
            );
        }

        function updateMeeting(mid, name, date, hr, min) {
            $("#modalEditAgenda").modal('show');
            $("#agendaName2").val(name)
            $("#agendaDate2").val(date)
            $("#hr2").val(hr)
            $("#min2").val(min)
            $("#mid-hidden").val(mid)
        }
    </script>
</body>

</html>