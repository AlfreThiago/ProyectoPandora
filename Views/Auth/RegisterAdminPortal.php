<?php

if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
    <div style="color: red; margin-bottom: 10px;">
        El correo electrónico ya está registrado. Por favor, usa otro.
    </div>
<?php endif; ?>

<body>
    <main>
        <div class="Contenedor">
            <section class="Conenedor-formulario-principal">
                <h2>Registrarse</h2>
                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                      
                        <form action="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" method="POST">
                            <p>
                                <label for="name">Nombre:</label>
                                <input type="text" name="name">
                            </p>
                            <p>
                                <label for="email">Email</label>
                                <input type="email" name="email" required>
                            </p>
                            <p>
                                <label for="password">password</label>
                                <input type="password" name="password" required>
                            </p>
                            <p>
                      <label for="role">Rol:</label>
                            </p>
                            <select name="role" id="role" required>
                                <option value="Cliente">Cliente</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Administrador">Admin</option>
                            </select>
                            <p>
                                <button type="submit">Registrar</button>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>