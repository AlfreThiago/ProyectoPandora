<main>
    <div class="Contenedor">
        <section class="Conenedor-formulario-principal">
            <h2>Agregar Dispositivo</h2>
            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form action="/ProyectoPandora/Public/index.php?route=Device/Agregar" method="POST" enctype="multipart/form-data">
                        <p>
                            <label for="categoria_id">Categoría del Dispositivo:</label>
                            <select id="categoria_id" name="categoria_id" required>
                                <option value="1">Celulares</option>
                                <option value="2">Computadora</option>
                                <option value="3">Tablet</option>
                                <option value="4">Electrodomésticos</option>
                                <option value="5">Televisores</option>
                            </select>
                        </p>
                        <p>
                            <label for="marca">Marca:</label>
                            <input type="text" id="marca" name="marca" required>
                        </p>
                        <p>
                            <label for="modelo">Modelo:</label>
                            <input type="text" id="modelo" name="modelo" required>
                        </p>
                        <p>
                            <label for="descripcion_falla">Descripción de Falla:</label>
                            <input type="text" id="descripcion_falla" name="descripcion_falla" required>
                        </p>
                        <p>
                            <label for="img_dispositivo">Imagen del Dispositivo:</label>
                            <input type="file" id="img_dispositivo" name="img_dispositivo" accept="image/*" required>
                        </p>
                        <p>
                            <button type="submit">Agregar Dispositivo</button>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>