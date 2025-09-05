<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
<main>
    <section class="content">
        <header class="header">
                <h1 class="header-title">Panel Administrador</h1>
                <p class="header-subtitle">
                    Bienvenido a la zona admin
                    <br>
                    <span class="user-highlight">
                        <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                    </span>
                </p>
                <div class="header-actions">
                    <!-- Notificaciones -->
                    <span class="icon-btn">
                        <i class='bx bx-bell'></i>
                    </span>

                    <!-- Chat -->
                    <span class="icon-btn">
                        <i class='bx bx-chat'></i>
                    </span>

                    <!-- Avatar -->
                    <span class="user-avatar"></span>
                </div>
            </header>
    </section>
</main>n