<section class="login-section">
    <div class="login-card">
        <h2>Iniciar Sesion</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="mensaje-error">Usuario o contraseña incorrectos.</div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE . 'index.php?action=autenticar'; ?>">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="input" required>
            </div>

            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="password" id="clave" name="clave" class="input" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>

            <div style="text-align:center; margin-top:10px;">
                <a href="<?php echo BASE . 'index.php'; ?>" class="btn btn-secondary">Volver al inicio</a>
            </div>
        </form>
    </div>
</section>

<style>
.login-section { display:flex; justify-content:center; align-items:flex-start; padding:40px 0; }
.login-card { width:360px; background:#fff; padding:24px; border-radius:6px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
.login-card h2 { text-align:center; margin-bottom:18px; }
.input { width:100%; padding:10px 12px; border:1px solid #e6e6e6; border-radius:4px; background:#fff8dc; }
.form-actions { margin-top:12px; }
.mensaje-error { background:#f8d7da; color:#721c24; padding:8px; border-radius:4px; margin-bottom:8px; }
</style>
