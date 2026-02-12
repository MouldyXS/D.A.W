<section class="form-section">
    <h2>Agregar Nuevo Usuario</h2>
    <form method="POST" action="<?php echo BASE . 'index.php?action=guardar'; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            <a href="<?php echo BASE . 'index.php'; ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</section>
