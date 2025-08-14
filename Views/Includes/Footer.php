        <div class="footer">
            <ul class="menu">
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bx bx-bell-minus'></i>
                        <span>Notificaciones</span>
                    </a>
                </li>
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class='bxr  bx-cog'></i>
                        <span>Ajustes</span>
                    </a>
                </li>
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
                    <div class="user-icon logout-icon">
                        <a href="/ProyectoPandora/Public/index.php?route=Auth/Logout">
                            <i class='bxr  bx-arrow-out-left-square-half'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>