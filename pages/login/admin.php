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
                    <li><a href="#" data-target="inicio"><i class="fa-solid fa-home"></i><span>Inicio</span></a></li>
                    <li><a href="#" data-target="productos"><i class="fa-solid fa-truck-fast"></i><span>Productos</span></a></li>
                    <li><a href="#" data-target="ventas"><i class="fa-solid fa-basket-shopping"></i><span>Ventas</span></a></li>
                    <li><a href="#" data-target="clientes"><i class="fa-solid fa-clipboard-list"></i><span>Clientes</span></a></li>
                    <li><a href="#" data-target="ajustes"><i class="fa-solid fa-sliders"></i><span>Ajustes</span></a></li>
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

            <div id="inicio" class="content">
                <div class="inicio-container">
                    <div class="contenedor">
                        <h3>DashBoard</h3>
                    </div>
                    <div class="info">
                        <div class="card-info">
                            
                        </div>
                        <div class="card-info">
                            
                        </div>
                        <div class="card-info">
                            
                        </div>
                    </div>
                </div>
            </div>



            <div id="productos" class="content active">
                <div class="productos-container">

                    <div class="contenedor">
                        <h3>Todos los productos</h3>
                        <button class="btnMostrarModal" data-target="modalProductos">Agregar Producto</button>
                    </div>

                    <div id="modalProductos" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal">&times;</span>
                            <form id="formAgregar" method="POST" action="../../php/login/agregar.php" enctype="multipart/form-data">
                                <label>Nombre</label>
                                <input type="text" name="nombre">
                                <label>Descripción</label>
                                <input type="text" name="descripcion">
                                <label>Precio</label>
                                <input type="number" name="precio" step="0.01">
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
                                <button type="submit" name="agregarProd">Agregar</button>
                            </form>
                        </div>
                    </div>

                    <table border="1">
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

                        $queryProd = "SELECT p.ID, p.Nombre, p.Precio, p.Descripción, p.CantidadEnStock, c.nombre as Categoria, p.foto
                  FROM producto p
                  INNER JOIN categoria c ON p.Categoria = c.cod";

                        $resultProd = $conn->query($queryProd);

                        if ($resultProd->num_rows > 0) {
                            while ($row = $resultProd->fetch_assoc()) {
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
                                echo "<span class='modificar' onclick=\"mostrarModalModificar('" . $row['ID'] . "', '" . $row['Nombre'] . "', '" . $row['Descripción'] . "', '" . $row['Precio'] . "', '" . $row['CantidadEnStock'] . "', '" . $row['Categoria'] . "')\">Modificar</span>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No se encontraron Productos.</td></tr>";
                        }

                        $conn->close();
                        ?>

                    </table>
                    <div id="modalModificarProducto" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal" onclick="cerrarModal('modalModificarProducto')">&times;</span>
                            <h2>Modificar Producto</h2>
                            <form id="formModificarProducto" method="POST" action="../../php/login/modificar.php" enctype="multipart/form-data">
                                <input type="hidden" id="producto_id" name="producto_id">
                                <label>Nombre</label>
                                <input type="text" id="nombre" name="nombre">
                                <label>Descripción</label>
                                <input type="text" id="descripcion" name="descripcion">
                                <label>Precio</label>
                                <input type="number" id="precio" name="precio" step="0.01">
                                <label>Stock</label>
                                <input type="number" id="stock" name="stock">
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
                                <label>Nueva Imagen</label>
                                <input type="file" id="imagen" name="imagen">
                                <button type="submit" name="modifiProd">Guardar Cambios</button>
                            </form>
                            <div id="mensajeProducto"></div>
                        </div>
                    </div>

                </div>
            </div>



            <div id="ventas" class="content">
                <div class="ventas-container">
                    <div class="contenedor">
                        <h3>Ventas</h3>
                    </div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                        <?php
                        require '../../php/conexion.php';
                        $query = "SELECT * FROM ventas";
                        $resultado = $conn->query($query);
                        if ($resultado ->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['ID'] . "</td>";
                                echo "<td>" . $row['UsuarioID'] . "</td>";
                                echo "<td>" . $row['Fecha'] . "</td>";
                                echo "<td>" . $row['Total'] . "</td>";
                                echo "<td>";
                                echo "<a href='../../php/login/eliminar/eliminar_user.php?id=" . $row['ID'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron ventas por el momento .</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                </div>
            </div>



            <div id="clientes" class="content">
                <div class="clientes-container">
                    <div class="contenedor">
                        <h3>Todos nuestros clientes</h3>
                    </div>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Password</th>
                            <th>Acciones</th>
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
                                echo "<a href='../../php/login/eliminar/eliminar_user.php?id=" . $row['ID'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a> ";
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



            <div id="ajustes" class="content">

                <div class="admins-container">
                    <div class="contenedor">
                        <h3>Administradores</h3>
                        <button class="btnMostrarModal" data-target="modalAdmins">Agregar Administrador</button>
                    </div>


                    <div id="modalAdmins" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal">&times;</span>
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
                        </div>
                    </div>



                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Password</th>
                            <th>Acciones</th>
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
                                echo "<a href='../../php/login/eliminar/eliminar_admin.php?id=" . $row['codigo'] . "' onclick='return confirm(\"¿Estás seguro de eliminar?\")'>Eliminar</a> | ";
                                echo "<span class='modificar' onclick=\"mostrarModalModificarAdmin('" . $row['codigo'] . "', '" . $row['nombre'] . "', '" . $row['apellido'] . "', '" . $row['correo'] . "', '" . $row['password'] . "')\">Modificar</span>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron administradores.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                    <!-- Modal para modificar administrador -->
                    <div id="modalModificarAdmin" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal" onclick="cerrarModal('modalModificarAdmin')">&times;</span>
                            <h2>Modificar Administrador</h2>
                            <form id="formModificarAdmin" method="POST" action="../../php/login/modificar.php">
                                <input type="hidden" id="admin_id" name="admin_id">
                                <label>Nombre</label>
                                <input type="text" id="nombreAdmin" name="nombreAdmin">
                                <label>Apellido</label>
                                <input type="text" id="apellido" name="apellido">
                                <label>Correo</label>
                                <input type="email" id="correo" name="correo">
                                <label>Password</label>
                                <input type="password" id="password" name="password">
                                <button type="submit" name="modifiAdmin">Guardar Cambios</button>
                            </form>
                            <div id="mensajeAdmin"></div>
                        </div>
                    </div>

                </div>

                <hr>

                <div class="icons-container">
                    <div class="contenedor">
                        <h3>Categorias</h3>
                        <button class="btnMostrarModal" data-target="modalIcons">Agregar Categoria</button>
                    </div>

                    <div id="modalIcons" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal">&times;</span>
                            <form method="POST" action="../../php/login/agregar.php" enctype="multipart/form-data">
                                <label>Codigo</label>
                                <input type="number" name="codigo">
                                <label>Nombre</label>
                                <input type="text" name="nombre">
                                <label>Imagen</label>
                                <input type="file" name="imagen">
                                <button type="submit" name="agregarCategoria">Agregar Categoria</button>
                            </form>
                        </div>
                    </div>


                    <table>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Icono</th>
                            <th>Acciones</th>
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
                                echo "<a href='../../php/login/eliminar/eliminar_cat.php?id=" . $row['cod'] . "' onclick='return confirm(\"¿Estás seguro de eliminar esta categoria?\")'>Eliminar</a> | ";
                                echo "<span class='modificar' onclick=\"mostrarModalModificarCat('" . $row['cod'] . "', '" . $row['nombre'] . "')\">Modificar</span>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron categorias.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </table>
                    <div id="modalModificarCategoria" class="modal">
                        <div class="modal-contenido">
                            <span class="cerrar-modal" onclick="cerrarModal('modalModificarCategoria')">&times;</span>
                            <h2>Modificar Categoría</h2>
                            <form id="formModificarCategoria" method="POST" action="../../php/login/modificar.php" enctype="multipart/form-data">
                                <input type="hidden" id="categoria_id" name="categoria_id">
                                <label for="nombreCategoria">Nombre:</label>
                                <input type="text" id="nombreCategoria" name="nombreCategoria">
                                <label for="imagenCategoria">Nueva Imagen:</label>
                                <input type="file" id="imagenCategoria" name="imagenCategoria">
                                <button type="submit" name="modificarCategoria">Guardar Cambios</button>
                            </form>
                            <div id="mensajeCategoria"></div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

    <script src="../../JS/login/script.js"></script>
    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>
    <!-- Dentro de tu archivo HTML, probablemente al final del body -->
    <script>
        function mostrarModalModificarAdmin(id, nombre, apellido, correo, password) {
            // Llenar el modal con los datos del administrador seleccionado
            document.getElementById('admin_id').value = id;
            document.getElementById('nombreAdmin').value = nombre;
            document.getElementById('apellido').value = apellido;
            document.getElementById('correo').value = correo;
            document.getElementById('password').value = password;

            // Mostrar el modal
            document.getElementById('modalModificarAdmin').style.display = 'block';
        }

        function mostrarModalModificar(id, nombre, descripcion, precio, stock, categoria) {
            // Rellenar los campos del formulario con los datos del producto
            document.getElementById('producto_id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('precio').value = precio;
            document.getElementById('stock').value = stock;
            document.getElementById('categoria').value = categoria;

            // Mostrar el modal
            document.getElementById('modalModificarProducto').style.display = 'block';
        }

        function mostrarModalModificarCat(id, nombre) {
            // Llenar el modal con los datos de la categoría seleccionada
            document.getElementById('categoria_id').value = id;
            document.getElementById('nombreCategoria').value = nombre;

            // Mostrar el modal
            document.getElementById('modalModificarCategoria').style.display = 'block';
        }

        // Función para cerrar el modal
        function cerrarModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Event listener para cerrar el modal al hacer click fuera del contenido
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }
    </script>


</body>


</html>