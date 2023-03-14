<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Admin | Panduan Pengguna </title>
    <link rel="shortcut icon" href="<?= IMAGES_URL ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css" />

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/byl4oikuvknydm7bl5aijyvsqxt16dkq9z0mtj35dibykwna/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak media',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | casechange blocks | bold italic backcolor | \
      alignleft aligncenter alignright alignjustify | \
      bullist numlist checklist outdent indent | removeformat |',
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
                        <p class="fs-3 fw-normal m-0">Panduan Pengguna</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active" aria-current="page">Panduan Pengguna</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Card Panels -->
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-circle-question"></i> &nbsp; Panduan Pengguna</p>
                                    <span>
                                        <button id="buttontrig1" class="btn btn-light btn-sm" onclick="triggerEditMode()"> <i class="fa-solid fa-file-pen"></i>&nbsp; Mode Edit</button>
                                        <button style="display: none" id="buttontrig2" class="btn btn-light btn-sm" onclick="triggerViewMode()"> <i class="fa-solid fa-file-pen"></i>&nbsp; Mode Baca</button>
                                    </span>
                                </div>
                                <div class="card-body p-2 p-sm-3 ">
                                    <div id="viewModeField">
                                        <?= $userGuide; ?>
                                    </div>
                                    <div id="editModeField" style="display: none">
                                        <form action="" method="POST">
                                            <textarea name="content" id="userguideedit" cols="30" rows="10"></textarea>
                                            <button type="submit" class="btn btn-sm btn-success mt-3"><i class="fa-solid fa-floppy-disk"></i> &nbsp; Simpan Perubahan</button>
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


    <script>
        $('#sidebar-item-guide').removeClass('sidebar-item').addClass('sidebar-active');
        $('#sidebar-item-projects').removeClass('sidebar-active').addClass('sidebar-item');

        function triggerEditMode() {
            $('#viewModeField').hide()
            $('#editModeField').show()

            $('#buttontrig1').hide()
            $('#buttontrig2').show()
            tinymce.get("userguideedit").setContent($('#viewModeField').html())
        }

        function triggerViewMode() {
            $('#viewModeField').show()
            $('#editModeField').hide()

            $('#buttontrig1').show()
            $('#buttontrig2').hide()
        }
    </script>
</body>

</html>