    <main>
        <div class="Contenedor">

            <section class="Conenedor-formulario-principal">
                <h2>Agregar Dispositivo
                </h2>

                <div class="Formulario-general">
                    <div class="Formulario-contenedor">
                        <form action="/ProyectoPandora/Public/index.php?route=Device/Agregar" method="POST">
                            <div class="Formulario-campo">
                                <label for="device_name">Nombre del Dispositivo:</label>
                                <input type="text" id="device_name" name="device_name" required>
                            </div>
                            <div class="Formulario-campo">
                                <label for="device_type">Tipo de Dispositivo:</label>
                                <input type="text" id="device_type" name="device_type" required>
                            </div>
                            <div class="Formulario-campo">
                                <label for="device_location"></label>
                                <input type="text" id="device_location" name="device_location" required>
                            </div>
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
                            <div class="Formulario-boton">
                                <button type="submit">Agregar Dispositivo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>