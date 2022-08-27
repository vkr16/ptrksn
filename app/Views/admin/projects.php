<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>AdminKSNIII | Dashboard </title>
    <link rel="shortcut icon" href="<?= IMAGES_URL ?>/a-logo.png" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css" />

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/byl4oikuvknydm7bl5aijyvsqxt16dkq9z0mtj35dibykwna/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help'
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
                        <p class="fs-3 fw-normal m-0">Projects Management</p>
                        <nav aria-label="breadcrumb" class="m-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active" aria-current="page">Projects</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Card Panels -->
                    <div class="container-fluid mt-3 row mx-0 px-0">
                        <div class="col-12">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-diagram-project"></i> &nbsp; Project List</p>
                                    <button class="btn btn-light btn-sm" onclick="openNewProjectPanel()"><i class="fa-solid fa-plus fa-fw"></i></button>
                                </div>
                                <div class="card-body p-2 p-sm-3 table-responsive">
                                    <div class="">
                                        <table class="table" id="projectTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Project Name</th>
                                                    <th>Progress</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($projects as $key => $project) {
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $project['name']; ?></td>
                                                        <td><?= $project['progress']; ?></td>
                                                        <td>
                                                            <a class="btn btn-sm btn-green" href="<?= HOST_URL ?>/admin/projects/detail?id=<?= $project['id']; ?>">View Details</a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="newProjectPanel" style="display: none">
                            <div class="card mb-3 shadow">
                                <div class="card-header bg-green-custom text-light p-3 d-flex justify-content-between align-items-center">
                                    <p class="m-0"><i class="fa-solid fa-clipboard"></i> &nbsp;Add New Project</p>
                                    <button class="btn btn-light btn-sm" onclick="$('#newProjectPanel').hide()"><i class="fa-solid fa-times fa-fw"></i></button>
                                </div>
                                <div class="card-body p-2 p-sm-3">
                                    <form action="<?= HOST_URL ?>/admin/projects/add" method="POST">
                                        <div class="mb-3">
                                            <label for="projectName" class="form-label">Project Name</label>
                                            <input type="text" class="form-control" id="projectName" name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="projectDescription" class="form-label">Project Description</label>
                                            <textarea name="description" id="projectDescription" cols="30" rows="10"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-green"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                    </form>
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
            var t = $('#projectTable').DataTable();
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

        function openNewProjectPanel() {
            $('#newProjectPanel').show();
        }
    </script>
</body>

</html>