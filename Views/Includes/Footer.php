<?php

?>

<body>
    <nav class="footer">
        <div class="menu-conteiner">
            <div class="user">
                <div class="user-data">
                    <?php
                    if (isset($_SESSION['user'])):
                    ?>
                        <span class="name"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                        <span class="email"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></span>
                    <?php else: ?>
                        <span class="name">Invitado</span>
                        <span class="email">Sin Sesión</span>
                    <?php endif; ?>
                </div>
                <div class="user-icon logout-icon">
                    <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                        <i class='bx bx-log-out'></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <script src="/ProyectoPandora/Public/js/Sidebar.js"></script>
</body>