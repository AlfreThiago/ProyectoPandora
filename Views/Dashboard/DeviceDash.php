<main>
    <div class="Conenedor">

        <section class="Conenedor-formulario-principal">
            <h2>Agregar Dispositivo</h2>

            <div class="Formulario-general">
                <div class="Formulario-contenedor">
                    <form action="/ProyectoPandora/Public/index.php?route=Device/Agregar" method="POST" enctype="multipart/form-data">
                        <div class="Formulario-campo">
                            <label for="categoria_id">Categoría del Dispositivo:</label>
                            <select id="categoria_id" name="categoria_id" required>
                                <option value="1">Celulares</option>
                                <option value="2">Computadora</option>
                                <option value="3">Tablet</option>
                                <option value="4">Televisores</option>
                                <option value="5">Electrodomésticos</option>
                            </select>
                        </div>
                        <div class="Formulario-campo">
                            <label for="marca">Marca:</label>
                            <input type="text" id="marca" name="marca" required>
                        </div>
                        <div class="Formulario-campo">
                            <label for="modelo">Modelo:</label>
                            <input type="text" id="modelo" name="modelo" required>
                        </div>
                        <div class="Formulario-campo">
                            <label for="descripcion_falla">Descripción de Falla:</label>
                            <input type="text" id="descripcion_falla" name="descripcion_falla" required>
                        </div>
                        <div class="Formulario-campo">
                            <label for="img_dispositivo">Imagen del Dispositivo:</label>
                            <input type="file" id="img_dispositivo" name="img_dispositivo" accept="image/*" required>
                        </div>

                        <div class="Formulario-contenedor">
                            <button type="submit">Agregar Dispositivo</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>