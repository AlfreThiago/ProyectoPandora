<?php include_once __DIR__ . '/../Includes/Header.php'; ?>
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
                        </div>
                    <?php elseif ($role === 'supervisor'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                        </div>
                    <?php elseif ($role === 'tecnico'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
                        </div>
                    <?php elseif ($role === 'cliente'): ?>
                        <div class="info-user">
                            <h2>BIENVENIDO <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Usuario'; ?></h2>
                        </div>
                        <div class="">
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
<?php include_once __DIR__ . '/../Includes/Footer.php' ?>