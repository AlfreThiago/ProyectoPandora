<main>
    <div class="ContenedorPrincipal">
        <div class="Contenedor-home texto">
            <h2>Home Portal</h2>
        </div>

        <section class="Contenido">
            <div class="informacion">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php $role = strtolower($_SESSION['user']['role']); ?>
                        <?php if ($role === 'administrador'): ?>
                            <div class="">
                                <div class="info-user">
                                    <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                                </div>
                            </div>
                        <?php elseif ($role === 'supervisor'): ?>
                            <div class="">
                                <div class="info-user">
                                    <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                                </div>
                            </div>
                        <?php elseif ($role === 'tecnico'): ?>
                            <div class="">
                                <div class="info-user">
                                    <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                                </div>
                                <div class="panel-opciones">
                                        <a href="" class="opcion">
                                            <h3>Ver Clientes Asignados</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, totam?</p>
                                        </a>
                                        <a href="" class="opcion">
                                            <h3>Cargar Reporte de Visita</h3>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam, earum.</p>
                                        </a>
                                        <a href="" class="opcion">
                                            <h3>Mis reportes</h3>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, officiis.</p>
                                        </a>
                                </div>
                            </div>
                        <?php elseif ($role === 'cliente'): ?>
                            <div class="">
                                <div class="info-user">
                                    <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="info-user">
                                <h2>BIENVENIDO A INNOVASYS</h2>
                            </div>
                        <?php endif; ?>
            </div>
        </section>
    </div>
</main>