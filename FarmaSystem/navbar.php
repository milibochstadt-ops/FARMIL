<nav class="navbar-custom">

    <div class="container">

        <div class="top-bar">

            <a href="index.php" class="logo">
                Farmil
            </a>

            <div class="buscador">
                <input type="text" placeholder="Buscar...">
            </div>

            <div class="usuario-box">

                <?php if (isset($_SESSION["nombre"])) { ?>
                    <span>
                        <?php echo $_SESSION["nombre"]; ?>
                    </span>
                <?php } ?>

                <a href="logout.php" class="btn-salir">
                    Salir
                </a>

            </div>

        </div>

        <div class="menu-principal">

            <a href="index.php">Inicio</a>
            <a href="medicamentos.php">Medicamentos</a>
            <a href="ventas.php">Ventas</a>
            <a href="caja.php">Caja</a>

        </div>

    </div>

</nav>