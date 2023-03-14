<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Akun Pengguna</title>
    <link rel="shortcut icon" href="<?= IMAGES_URL ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css" />


</head>

<body>

    <div class="d-flex">
        <?= $this->include('layout_components/sidebar'); ?>
        <section class="vh-100 w-100 scrollable-y">
            <?= $this->include('layout_components/topbar'); ?>
            <div class="w-100">
                <div class="container-fluid">
                    <div class="col-md-12 d-flex justify-content-between align-items-center p-3 my-2">
                        <p class="fs-3 fw-normal m-0">Manajemen Akun Pengguna</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active" aria-current="page">Akun Pengguna</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Card Panels -->
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-4 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-users-gear"></i> &nbsp; Akun Pengguna</p>
                                    <!-- <button class="btn btn-light btn-sm" id="userAddButton"><i class="fa-solid fa-plus"></i></button> -->
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <table class="table" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>NIP</th>
                                                    <th>NIK</th>
                                                    <th>Instansi</th>
                                                    <th>Jabatan</th>
                                                    <th>Email</th>
                                                    <th>No. Telepon</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($userAccounts as $key => $user) {
                                                ?>
                                                    <tr class="text-<?= $user['role'] == 'Admin' ? 'success' : 'dark'; ?>">
                                                        <td></td>
                                                        <td><?= $user['name']; ?></td>
                                                        <td><?= $user['nip']; ?></td>
                                                        <td><?= $user['nik']; ?></td>
                                                        <td><?= $user['instance']; ?></td>
                                                        <td><?= $user['position']; ?></td>
                                                        <td><?= $user['email']; ?></td>
                                                        <td><?= $user['phone']; ?></td>

                                                        <td><?= $user['status'] == 'Active' ? '<i class="fa-solid fa-circle-check text-success"></i>' : '<i class="fa-solid fa-circle-pause text-danger"></i>'; ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" role="button" onclick="openUserEditModal(<?= $user['id']; ?>)"><i class="fa-solid fa-user-pen fa-fw"></i>&nbsp; Ubah
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" role="button" onclick="openUserPasswordResetModal(<?= $user['id']; ?>)"><i class="fa-solid fa-lock-open fa-fw"></i>&nbsp; Atur Ulang Kata Sandi
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" role="button" onclick="userDeletePrompt(<?= $user['id']; ?>,'<?= $user['name']; ?>')"><i class="fa-solid fa-trash-alt fa-fw"></i>&nbsp; Hapus Akun
                                                                        </a>
                                                                    </li>
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
                        <div class="col-md-6">
                            <div class="card mb-4 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-user-plus"></i> &nbsp; Tambah Akun Pengguna Baru</p>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <form action="<?= HOST_URL ?>/admin/users/add" method="POST">
                                            <div class="mb-3">
                                                <label for="InputName1" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="InputName1" name="name" placeholder="Nama Lengkap">
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-6 pe-2">
                                                    <div class="mb-3">
                                                        <label for="InputNIP1" class="form-label">NIP</label>
                                                        <input type="number" class="form-control" id="InputNIP1" name="nip" placeholder="NIP">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ps-2">
                                                    <div class="mb-3">
                                                        <label for="InputNIK1" class="form-label">NIK</label>
                                                        <input type="number" class="form-control" id="InputNIK1" name="nik" placeholder="NIK">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="SelectRole1" class="form-label">Instansi</label>
                                                <select class="form-select" name="instanceselect" id="instance" onchange="isNewInstance()">
                                                    <option class="text-mute">- Instansi Asal -</option>
                                                    <?php
                                                    foreach ($instances as $key => $instance) {
                                                    ?>
                                                        <option class="text-mute" value="<?= $instance->instance; ?>">
                                                            <?= $instance->instance; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option class="text-mute" value="newinstance12345">Lainnya</option>
                                                </select>
                                                <input type="text" class="form-control mt-2" style="display: none" id="InputInstance1" name="instance" placeholder="Instansi Asal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="SelectRole1" class="form-label">Jabatan</label>
                                                <select class="form-select" name="positionselect" id="position" onchange="isNewPosition()">
                                                    <option class="text-mute">- Jabatan -</option>
                                                    <?php
                                                    foreach ($positions as $key => $position) {
                                                    ?>
                                                        <option class="text-mute" value="<?= $position->position; ?>">
                                                            <?= $position->position; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option class="text-mute" value="newposition12345">Lainnya</option>
                                                </select>
                                                <input type="text" class="form-control mt-2" style="display: none" id="InputPosition1" name="position" placeholder="Jabatan">
                                            </div>
                                            <div class="mb-3">
                                                <label for="InputPhone1" class="form-label">No. Telepon</label>
                                                <input type="number" class="form-control" id="InputPhone1" name="phone" placeholder="No. Telepon">
                                            </div>
                                            <div class="mb-3">
                                                <label for="InputEmail1" class="form-label">Alamat Email</label>
                                                <input type="email" class="form-control" id="InputEmail1" name="email" placeholder="Alamat Email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>
                                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Kata Sandi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="SelectRole1" class="form-label">Jenis Akun</label>
                                                <select class="form-select" name="role">
                                                    <option value="User">User (Default)</option>
                                                    <option value="Admin">Admin</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-green"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Simpan</button>
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

    <!-- Modal -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userEditModalLabel">Ubah Informasi Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= HOST_URL ?>/admin/users/update" method="POST">
                        <input type="text" hidden id="updateid" name="id">
                        <div class="mb-3">
                            <label for="InputName2" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="InputName2" placeholder="Nama Lengkap">
                        </div>
                        <div class="d-flex">
                            <div class="col-md-6 pe-2">
                                <div class="mb-3">
                                    <label for="InputNIP2" class="form-label">NIP</label>
                                    <input type="number" class="form-control" id="InputNIP2" name="nip" placeholder="NIP">
                                </div>
                            </div>
                            <div class="col-md-6 ps-2">
                                <div class="mb-3">
                                    <label for="InputNIK2" class="form-label">NIK</label>
                                    <input type="number" class="form-control" id="InputNIK2" name="nik" placeholder="NIK">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="SelectRole1" class="form-label">Instansi</label>
                            <select class="form-select" name="instanceselect" id="instance2" onchange="isNewInstance()">
                                <option class="text-mute">- Instansi Asal -</option>
                                <?php
                                foreach ($instances as $key => $instance) {
                                ?>
                                    <option class="text-mute" value="<?= $instance->instance; ?>">
                                        <?= $instance->instance; ?>
                                    </option>
                                <?php
                                }
                                ?>
                                <option class="text-mute" value="newinstance12345">Lainnya</option>
                            </select>
                            <input type="text" class="form-control mt-2" style="display: none" id="InputInstance2" name="instance" placeholder="Instansi Asal">
                        </div>
                        <div class="mb-3">
                            <label for="SelectRole1" class="form-label">Jabatan</label>
                            <select class="form-select" name="positionselect" id="position2" onchange="isNewPosition()">
                                <option class="text-mute">- Jabatan -</option>
                                <?php
                                foreach ($positions as $key => $position) {
                                ?>
                                    <option class="text-mute" value="<?= $position->position; ?>">
                                        <?= $position->position; ?>
                                    </option>
                                <?php
                                }
                                ?>
                                <option class="text-mute" value="newposition12345">Lainnya</option>
                            </select>
                            <input type="text" class="form-control mt-2" style="display: none" id="InputPosition2" name="position" placeholder="Jabatan">
                        </div>
                        <div class="mb-3">
                            <label for="InputPhone2" class="form-label">No. Telepon</label>
                            <input type="number" class="form-control" name="phone" id="InputPhone2" placeholder="No. Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="InputEmail2" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" name="email" id="InputEmail2" placeholder="Alamat Email">
                        </div>
                        <div class="mb-3">
                            <label for="SelectRole2" class="form-label">Jenis Akun</label>
                            <select class="form-select" name="role" id="SelectRole2">
                                <option value="User">User (Default)</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="SelectStatus2" class="form-label">Status Akun</label>
                            <select class="form-select" name="status" id="SelectStatus2">
                                <option value="Active">Aktif (Default)</option>
                                <option value="Suspended">Tangguhkan</option>
                            </select>
                            <input type="text" name="hiddenstatus" id="hiddenstatus" hidden readonly>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reset Passw-->
    <div class="modal fade" id="userPasswordResetModal" tabindex="-1" aria-labelledby="userPasswordResetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userPasswordResetModalLabel">Atur Ulang Kata Sandi Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= HOST_URL ?>/admin/users/resetPassword" method="POST">
                        <input type="text" hidden id="resetid" name="id">
                        <div class="mb-3">
                            <label for="InputPassword3" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="password" id="InputPassword3" placeholder="Kata Sandi Baru">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
    <script src="<?= ASSETS_URL ?>/js/notiflix-aio-3.2.5.min.js"></script>

    <!-- Datatables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script>
        Notiflix.Notify.init({
            width: '300px',
            position: 'right-top',
            closeButton: false,
            distance: '30px',
        });
        Notiflix.Confirm.init({
            borderRadius: '10px',
            titleColor: '#417230',
            okButtonBackground: '#417230',
        })

        $(document).ready(function() {
            var t = $('#myTable').DataTable({
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

        $('#sidebar-item-users').removeClass('sidebar-item').addClass('sidebar-active');
        $('#sidebar-item-projects').removeClass('sidebar-active').addClass('sidebar-item');

        function openUserEditModal(id) {
            $('#userEditModal').modal('show');

            $.post("users/getUserData", {
                    id: id
                })
                .done(function(data) {
                    var userData = JSON.parse(data)
                    $('#updateid').val(userData[0].id)
                    $('#InputName2').val(userData[0].name)
                    $('#InputEmail2').val(userData[0].email)
                    $('#InputPhone2').val(userData[0].phone)
                    $('#InputNIP2').val(userData[0].nip)
                    $('#InputNIK2').val(userData[0].nik)
                    $('#instance2').val(userData[0].instance).change()
                    $('#position2').val(userData[0].position).change()
                    $('#SelectRole2').val(userData[0].role).change()
                    $('#SelectStatus2').val(userData[0].status).change()
                    $('#hiddenstatus').val(userData[0].status)
                    if (<?= $userData['id']; ?> == userData[0].id) {
                        $("#SelectStatus2").prop("disabled", "disabled")
                    } else {
                        $("#SelectStatus2").prop("disabled", false)

                    }
                });
        }

        function openUserPasswordResetModal(id) {
            $('#userPasswordResetModal').modal('show');
            $('#resetid').val(id)
        }

        function userDeletePrompt(id, name) {
            Notiflix.Confirm.show(
                'Hapus Akun',
                'Anda yakin ingin menghapus akun ' + name + '? ',
                'Ya',
                'Batal',
                () => {
                    $.post("users/delete", {
                            id: id
                        })
                        .done(function(data) {
                            Notiflix.Notify.success("Deleted!");

                            setTimeout(function() {
                                window.location.reload()
                            }, 1000);
                        });
                },
                () => {}, {},
            );
        }

        function isNewInstance() {
            if ($("#instance").val() == 'newinstance12345') {
                $("#InputInstance1").show();
            } else {
                $("#InputInstance1").hide();
                $("#InputInstance1").val('');
            }
            if ($("#instance2").val() == 'newinstance12345') {
                $("#InputInstance2").show();
            } else {
                $("#InputInstance2").hide();
                $("#InputInstance2").val('');
            }
        }

        function isNewPosition() {
            if ($("#position").val() == 'newposition12345') {
                $("#InputPosition1").show();
            } else {
                $("#InputPosition1").hide();
                $("#InputPosition1").val('')
            }
            if ($("#position2").val() == 'newposition12345') {
                $("#InputPosition2").show();
            } else {
                $("#InputPosition2").hide();
                $("#InputPosition2").val('')
            }
        }
    </script>
</body>

</html>

<?php
if (isset($_COOKIE['reset-password']) && $_COOKIE['reset-password'] == 'success') {
    echo '
    <script>
        Notiflix.Notify.success("Password Reset Successfully");
    </script>';
} else if (isset($_COOKIE['reset-password']) && $_COOKIE['reset-password'] == 'failed') {
    echo '
    <script>
        Notiflix.Notify.failure("Password Reset Failed");
    </script>';
}

if (isset($_COOKIE['updated']) && $_COOKIE['updated'] == 'success') {
    echo '
    <script>
        Notiflix.Notify.success("User Info Updated Successfully");
    </script>';
} else if (isset($_COOKIE['updated']) && $_COOKIE['updated'] == 'failed') {
    echo '
    <script>
        Notiflix.Notify.failure("User Info Update Failed");
    </script>';
}

if (isset($_COOKIE['add']) && $_COOKIE['add'] == 'success') {
    echo '
    <script>
        Notiflix.Notify.success("User Added Successfully");
    </script>';
} else if (isset($_COOKIE['add']) && $_COOKIE['add'] == 'failed') {
    echo '
    <script>
        Notiflix.Notify.failure("User Add Failed");
    </script>';
} else if (isset($_COOKIE['add']) && $_COOKIE['add'] == 'exist') {
    echo '
    <script>
        Notiflix.Notify.failure("User Already Exist");
    </script>';
}
?>