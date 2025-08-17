<body>
    <nav class="footer">
        <div class="menu-conteiner">
            <ul class="menu-items">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php $role = strtolower($_SESSION['user']['role']); ?>

                    <?php if ($role === 'administrador'): ?>
                        <!-- Admin: ve todos los usuarios y opción de añadir -->
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bx bx-bell-minus'></i>
                                <span>Notificaciones</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bxr  bx-cog'></i>
                                <span>Ajustes</span>
                            </a>
                        </li>
                    <?php elseif ($role === 'supervisor'): ?>
                        <!-- Supervisor: ve técnicos y clientes -->
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bxr  bx-cog'></i>
                                <span>Ajustes</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bx bx-bell-minus'></i>
                                <span>Notificaciones</span>
                            </a>
                        </li>

                    <?php elseif ($role === 'tecnico'): ?>
                        <!-- Técnico: solo ve Reparaciones y tickets -->
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bxr  bx-cog'></i>
                                <span>Ajustes</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bx bx-bell-minus'></i>
                                <span>Notificaciones</span>
                            </a>
                        </li>
                    <?php elseif ($role === 'cliente'): ?>
                        <!-- Agregar Dispositivo -->
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bxr  bx-cog'></i>
                                <span>Ajustes</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#" class="link flex">
                                <i class='bx bx-bell-minus'></i>
                                <span>Notificaciones</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- No logueado -->
                    <!-- Ajustes -->
                    <li class="item">
                        <a href="#" class="link flex">
                            <i class='bxr  bx-cog'></i>
                            <span>Ajustes</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- Muestra el nombre y correo del usuario conectado -->
            <div class="user">
                <div class="user-data">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="user-data">
                            <span class="name">
                                <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?>
                            </span>
                            <span class="email">
                                <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'correo@ejemplo.com'; ?>
                            </span>
                        </div>
                    <?php endif; ?>
                 <!-- Mostrar esto SOLO si NO hay sesión iniciada -->
                        <?php if (!isset($_SESSION['user'])): ?>
                        <div class="profile">
                            <div class="profile-info">
                                <span class="name">Invitado</span>
                                <span class="email">Sin Sesión</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class=" user-icon logout-icon">
                            <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout" >
                                <i class='bxr  bx-arrow-out-left-square-half logout-icon'></i>
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </nav>
    <script src="/ProyectoPandora/Public/js/Sidebar.js"></script>
</body>