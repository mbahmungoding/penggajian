<!-- TOAST -->
<div class="toast-container position-fixed top-0 end-0 p-3 z-3 position-absolute">
    <?php
    if (isset($_SESSION['pesan'])) {
    ?>
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="logo.png" class="rounded me-2" alt="..." width="5%">
                <strong class="me-auto">Login</strong>
                <small>Sekarang</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-white">
                <?php echo $_SESSION['pesan']  ?>
            </div>
        </div>
    <?php
    }
    unset($_SESSION['pesan']);
    ?>

</div>

<!-- MENU -->
<nav class="sidebar close shadow pt-4">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="logo.png" alt="Logo">
            </span>

            <div class="text logo-text">
                <span class="name">PROKOMPIM</span>
                <span class="profession">Admin</span>
            </div>
        </div>
    </header>

    <div class="menu-bar pt-4">
        <div class="bottom-content">

            <li class="nav-link">
                <a href="dashboard.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                        </svg>
                    </i>
                    <span class="text nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="input_golongan.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_golongan.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-layers" viewBox="0 0 16 16">
                            <path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882zm3.515 7.008L14.438 10 8 13.433 1.562 10 4.25 8.567l3.515 1.874a.5.5 0 0 0 .47 0zM8 9.433 1.562 6 8 2.567 14.438 6z" />
                        </svg>
                    </i>
                    <span class="text nav-text">Data Golongan</span>
                </a>
            </li>

            <li class="nav-link">
                <a href="input_staf.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_staf.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                        </svg>
                    </i>
                    <span class="text nav-text">Data Karyawan</span>
                </a>
            </li>

            <li class="nav-link">
                <a href="input_kehadiran.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_kehadiran.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </i>
                    <span class="text nav-text">Data Kehadiran</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="input_absen.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_absen.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-x" viewBox="0 0 16 16">
                            <path d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </i>
                    <span class="text nav-text">Data Absen</span>
                </a>
            </li>

            <li class="nav-link">
                <a href="input_potongan.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_potongan.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                            <path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.637L7.19 8.61zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0m7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                        </svg>
                    </i>
                    <span class="text nav-text">Potongan</span>
                </a>
            </li>

            <li class="nav-link">
                <a href="input_gaji.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_gaji.php') ? 'active' : ''; ?>">
                    <i class='bx icon'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                        </svg>
                    </i>
                    <span class="text nav-text">Penggajian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </i> <span class="text nav-text">Laporan</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?php echo (basename($_SERVER['REQUEST_URI']) == 'laporan_gaji_perbulan.php') ? 'active' : ''; ?>" href="laporan_gaji_perbulan.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_golongan.php') ? 'active' : ''; ?>">
                    <span class="text nav-text" aria-labelledby="navbarDropdown">Laporan Gaji Perbulan</span>
                    </a>
                    <a class="dropdown-item <?php echo (basename($_SERVER['REQUEST_URI']) == 'slip_gaji.php') ? 'active' : ''; ?>" href="slip_gaji.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'input_golongan.php') ? 'active' : ''; ?>">

                        <span class="text nav-text" aria-labelledby="navbarDropdown">Laporan Slip Gaji</span>
                    </a>
                </div>
            </li>
        </div>
        <div class="bottom-content">
            <li class="">
                <a href="logout.php">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

        </div>
    </div>
</nav>