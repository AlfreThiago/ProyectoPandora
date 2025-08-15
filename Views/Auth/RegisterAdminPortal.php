    <main>
        <?php
        // Si la URL tiene error=EmailYaRegistrado, mostramos un mensaje de error en rojo
        if (isset($_GET['error']) && $_GET['error'] === 'EmailYaRegistrado'): ?>
            <div style="color: red; margin-bottom: 10px;">
                El correo electrónico ya está registrado. Por favor, usa otro.
            </div>
        <?php endif; ?>
        <div class="Contenedor">
            <section class="Conenedor-formulario-principal">
                <h2>Añadir Usuario</h2>
                <div class="Formulario-general">
                    <div class="Formulario-contenedor">

                        <form action="/ProyectoPandora/Public/index.php?route=Register/RegisterAdminPortal" method="POST">
                            <p>
                                <label for="name">Nombre:</label>
                                <input type="text" name="name" autocomplete="off" required>
                            </p>
                            <p>
                                <label for="email">Email</label>
                                <input type="email" name="email" autocomplete="off" required>
                            </p>
                            <p>
                                <label for="password">password</label>
                                <input type="password" name="password" autocomplete="off" required>
                            </p>
                            <p>
                                <label for="role">Rol:</label>
                                <select name="role" required>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Cliente">Cliente</option>
                                </select>
                            </p>
                            <p>
                                <button type="submit">Registrar</button>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>