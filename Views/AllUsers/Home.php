<?php include_once __DIR__ . '/../Includes/Sidebar.php'; ?>
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
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                            <tbody>
                                <div class="grid">
                                    <div class="small-box">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p>New Orders</p>
                                        </div>
                                    <div class="icon">👜</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>

                                    <div class="small-box" style="background:var(--color-texto-primario);">
                                        <div class="inner">
                                            <h3>53</h3>
                                            <p>Users Registered</p>
                                        </div>
                                        <div class="icon">👤</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>
                                </div>

                            </tbody>
                        </div>
                    <?php elseif ($role === 'supervisor'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                            <tbody>
                                <div class="grid">
                                    <div class="small-box">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p>New Orders</p>
                                        </div>
                                    <div class="icon">👜</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>

                                    <div class="small-box" style="background:var(--color-texto-primario);">
                                        <div class="inner">
                                            <h3>53</h3>
                                            <p>Users Registered</p>
                                        </div>
                                        <div class="icon">👤</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>
                                </div>

                            </tbody>
                        </div>
                    <?php elseif ($role === 'tecnico'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                            <tbody>
                                <div class="grid">
                                    <div class="small-box">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p>New Orders</p>
                                        </div>
                                    <div class="icon">👜</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>

                                    <div class="small-box" style="background:var(--color-texto-primario);">
                                        <div class="inner">
                                            <h3>53</h3>
                                            <p>Users Registered</p>
                                        </div>
                                        <div class="icon">👤</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>
                                </div>

                            </tbody>
                        </div>
                    <?php elseif ($role === 'cliente'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                            <tbody>
                                <div class="grid">
                                    <div class="small-box">
                                        <div class="inner">
                                            <h3>150</h3>
                                            <p>New Orders</p>
                                        </div>
                                    <div class="icon">👜</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>

                                    <div class="small-box" style="background:var(--color-texto-primario);">
                                        <div class="inner">
                                            <h3>53</h3>
                                            <p>Users Registered</p>
                                        </div>
                                        <div class="icon">👤</div>
                                        <a href="#" class="small-box-footer">
                                            More info →
                                        </a>
                                    </div>
                                </div>

                            </tbody>
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