<section id="sidebar-section">
    <div class="offcanvas-lg offcanvas-start custom-sidebar bg-green-custom text-light" data-bs-scroll="true" tabindex="-1" id="sidebarPanelOffCanvas" aria-labelledby="sidebarPanelOffCanvasLabel">
        <div class="custom-sidebar bg-green-custom text-light vh-100 scrollable-y hide-scrollbar px-2">
            <a href="#home" class="py-3 mb-3 px-0 container-fluid d-flex gap-2 align-items-center sticky-top bg-green-custom text-light border-bottom border-light border-opacity-25 text-decoration-none" id="sidebar-header" style="z-index: 1000">
                <!-- <img src="<?= IMAGES_URL ?>/a-logo.png" width="30">
                <p class="fw-semibold h5 m-0 ">Admin<span class="fw-light">KSNIII</span></p> -->
                <img src="<?= IMAGES_URL ?>/logo-banner.png" class="w-100" alt="">
            </a>

            <ul class="list-unstyled m-0 p-0">
                <li>
                    <a href="<?= HOST_URL ?>/admin/projects" class="mb-2 px-3 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light  sidebar-active" id="sidebar-item-projects">
                        <div class=" m-0"> <i class="fa-solid fa-diagram-project fa-fw"></i> &nbsp; Kegiatan</div>
                    </a>
                </li>
                <li>
                    <a href="<?= HOST_URL ?>/admin/meetings" class="mb-2 px-3 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light sidebar-item" id="sidebar-item-meetings">
                        <div class=" m-0"> <i class="fa-solid fa-clipboard-check fa-fw"></i> &nbsp; Data Kehadiran</div>
                    </a>
                </li>
                <!-- <li>
                    <a href="#management-collapse" class="mb-2 px-3 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light sidebar-item btn-toggle collapsed justify-content-between" data-bs-toggle="collapse" aria-expanded="false">
                        <div class=" m-0"> <i class="fa-solid fa-list-check"></i> &nbsp; Management</div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="management-collapse">
                        <ul class="btn-toggle-nav list-unstyled">
                            <li>
                                <a href="#dashboard" class="mb-2 px-5 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light sidebar-item ">
                                    <div class=" m-0"> <i class="fa-solid fa-chart-line"></i> &nbsp; Finance</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <li>
                    <a href="<?= HOST_URL ?>/admin/users" class="mb-2 px-3 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light sidebar-item " id="sidebar-item-users">
                        <div class=" m-0"> <i class="fa-solid fa-users-gear fa-fw"></i> &nbsp; Akun Pengguna</div>
                    </a>
                </li>
                <li>
                    <a href="<?= HOST_URL ?>/admin/guide" class="mb-2 px-3 py-2 rounded container-fluid d-flex gap-2 align-items-center sticky-top text-light sidebar-item " id="sidebar-item-guide">
                        <div class=" m-0"> <i class="fa-solid fa-circle-question fa-fw"></i> &nbsp; Panduan Pengguna</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>