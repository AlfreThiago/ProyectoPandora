<main>
    <div class="Contenedor">
        <section class="Contenedor-home">
            <nav class="Menu">
                <ul class="Menu-lista">
                    <li class="item menu-item-dropdown">
                        <a href="#" class="link flex">
                            <i class='bx bx-home'></i>
                            <span>Inicio</span>
                        </a>
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php $role = strtolower($_SESSION['user']['role']); ?>

                            <?php if ($role === 'administrador'): ?>



                                <div class="Contenedor-home">
                                    <h2>ADMIN PORTAL</h2>
                                </div>

                            <?php elseif ($role === 'supervisor'): ?>
                                <div class="Contenedor-home">
                                    <h2>SUPERVISOR PORTAL</h2>
                                </div>
                            <?php elseif ($role === 'tecnico'): ?>
                                <div class="Contenedor-home">
                                    <h2>TECNICO PORTAL</h2>
                                </div>
                            <?php elseif ($role === 'cliente'): ?>
                                <div class="Contenedor-home">
                                    <h2>CLIENTE PORTAL</h2>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="Contenedor-home">
                                <h2>BIENVENIDO A Innovasys</h2>
                                <p>Por favor, inicia sesión para continuar.</p>
                            </div>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
            <div class="Contenedor-formulario-principal">
                <h2>Agregar Dispositivo</h2>
            </div>
        </section>
    </div>
</main>