<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../login/login.php"); // Redirigir al inicio de sesión
    exit;
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin</title>
    <link rel="stylesheet" href="../../scss/login/admin.css">
</head>

<body>
    <div class="admin-dashboard">

        <div class="ds-left-menu ">

            <button class="btn-menu">
                <i class="fa-solid fa-circle-chevron-left"></i>
            </button>

            <div class="ds-perfil">
                <div class="foto">
                    <img src="https://raw.githubusercontent.com/juliocesardw/dasboard/main/perfil.jpg" alt="">
                </div>
                <div class="info-perfil">
                    <span>Admin</span>
                    <h3><?php echo $_SESSION['admin']; ?></h3>
                </div>
            </div>

            <div class="ds-menu">

                <ul>
                    <li><a><i class="fa-solid fa-home"></i><span>Inicio</span></a></li>
                    <li><a onclick="cargarFormulario('productos.php')"><i class="fa-solid fa-truck-fast"></i><span>Productos</span></a></li>
                    <li><a><i class="fa-solid fa-gift"></i><span>Ofertas</span></a></li>
                    <li><a><i class="fa-solid fa-basket-shopping"></i><span>Ventas</span></a></li>
                    <li><a><i class="fa-solid fa-clipboard-list"></i><span>Clientes</span></a></li>
                    <li><a onclick="cargarFormulario('ajustes.php')"><i class="fa-solid fa-sliders"></i><span>Ajustes</span></a></li>

                </ul>

            </div>

            <div class="sign-off">
                <a href="?logout=true" class="btn-sign-off">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>


        </div>

        <div class="ds-panel">

            <div class="inicio"></div>



            <div class="productos">
                <div class="productos-container">
                    <form method="POST" action="../../php/login/agregar.php" enctype="multipart/form-data">
                        <label>Nombre</label>
                        <input type="text" name="nombre">
                        <label>Descripción</label>
                        <input type="text" name="descripcion">
                        <label>Precio</label>
                        <input type="number" name="precio">
                        <label>Stock</label>
                        <input type="number" name="stock">
                        <label>Categoría</label>
                        <select id="categoria" name="categoria">
                            <?php
                            include '../../php/conexion.php';
                            $query = "SELECT cod, nombre FROM categoria";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['cod'] . "'>" . $row['nombre'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                        <label>Imagen</label>
                        <input type="file" name="imagen">
                        <button type="submit" name="agregarProd">Agregar Producto</button>
                    </form>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Stock</th>
                            <th>Categoria</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                        <?php
                        require '../../php/conexion.php';
                        $queryCat = "SELECT * FROM producto";
                        $resultCat = $conn->query($queryCat);
                        if ($resultCat->num_rows > 0) {
                            while ($row = $resultCat->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['ID'] . "</td>";
                                echo "<td>" . $row['Nombre'] . "</td>";
                                echo "<td>" . $row['Precio'] . "</td>";
                                echo "<td>" . $row['Descripción'] . "</td>";
                                echo "<td>" . $row['CantidadEnStock'] . "</td>";
                                echo "<td>" . $row['Categoria'] . "</td>";
                                echo "<td><img src='data:image/png;base64," . base64_encode($row['foto']) . "' alt='Imagen del producto'></td>";
                                echo "<td>";
                                echo "<a href='../../php/login/eliminar/eliminar_prod.php?id=" . $row['ID'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> | ";
                                echo "<a href='modificar_producto.php?id=" . $row['ID'] . "'>Modificar</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron Prdouctos.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                </div>

            </div>


            <div class="ofertas"></div>



            <div class="ventas"></div>



            <div class="clientes">
                <div class="clientes-container">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Password</th>
                        </tr>
                        <?php
                        require '../../php/conexion.php';
                        $query = "SELECT * FROM usuarios";
                        $resultAdmins = $conn->query($query);
                        if ($resultAdmins->num_rows > 0) {
                            while ($row = $resultAdmins->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['ID'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['apellido'] . "</td>";
                                echo "<td>" . $row['correo'] . "</td>";
                                echo "<td>" . $row['telefono'] . "</td>";
                                echo "<td>" . $row['password'] . "</td>";
                                echo "<td>";
                                echo "<a href='../../php/login/eliminar/eliminar_user.php?id=" . $row['ID'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> | ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron administradores.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                </div>

            </div>




            <div class="ajustes">
                <div class="admins-container">
                    <form method="POST" action="../../php/login/agregar.php" enctype="multipart/form-data">
                        <label>Nombre</label>
                        <input type="text" name="nombreAdmin" required>
                        <label>Apellido</label>
                        <input type="text" name="apellido" required>
                        <label>Correo</label>
                        <input type="text" name="correo">
                        <label>Contraseña</label>
                        <input type="password" name="password">
                        <button type="submit" name="agregarAdmin">Agregar Administrador</button>
                    </form>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Password</th>
                        </tr>
                        <?php
                        require '../../php/conexion.php';
                        $queryAdmins = "SELECT * FROM admins";
                        $resultAdmins = $conn->query($queryAdmins);
                        if ($resultAdmins->num_rows > 0) {
                            while ($row = $resultAdmins->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['codigo'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['apellido'] . "</td>";
                                echo "<td>" . $row['correo'] . "</td>";
                                echo "<td>" . $row['password'] . "</td>";
                                echo "<td>";
                                echo "<a href='../../php/login/eliminar/eliminar_admin.php?id=" . $row['codigo'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> | ";
                                echo "<a href='modificar_producto.php?id=" . $row['codigo'] . "'>Modificar</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron administradores.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                </div>

                <div class="icons-conatiner">
                    <form method="POST" action="../../php/login/agregar.php" enctype="multipart/form-data">
                        <label>Codigo</label>
                        <input type="number" name="codigo">
                        <label>Nombre</label>
                        <input type="text" name="nombre">
                        <label>Imagen</label>
                        <input type="file" name="imagen">
                        <button type="submit" name="agregarCategoria">Agregar Categoria</button>
                    </form>
                    <table>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Icono</th>
                        </tr>
                        <?php
                        require '../../php/conexion.php';
                        $queryCat = "SELECT * FROM categoria";
                        $resultCat = $conn->query($queryCat);
                        if ($resultCat->num_rows > 0) {
                            while ($row = $resultCat->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['cod'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td><img src='data:image/png;base64," . base64_encode($row['icono']) . "' alt='Imagen del producto'></td>";
                                echo "<td>";
                                echo "<a href='../../php/login/eliminar/eliminar_cat.php?id=" . $row['cod'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> | ";
                                echo "<a href='modificar_producto.php?id=" . $row['cod'] . "'>Modificar</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron categorias.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <script src="../../JS/login/script.js"></script>
    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>

</body>

</html>