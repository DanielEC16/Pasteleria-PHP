<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Dashboard</title>
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../../scss/login/admin.css">
    <!-- CUSTOM JS -->

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
                    <h3>Josue</h3>
                </div>
            </div>

            <div class="ds-menu">

                <ul>
                    <li><a href="#"><i class="fa-solid fa-home"></i><span>Inicio</span></a></li>
                    <li><a href="#" onclick="cargarFormulario('formulario-agregar.php')"><i class="fa-solid fa-truck-fast"></i><span>Productos</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-gift"></i><span>Ofertas</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-basket-shopping"></i><span>Ventas</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-clipboard-list"></i><span>Clientes</span></a></li>
                    <li><a href="#" onclick="cargarFormulario('ajustes.php')"><i class="fa-solid fa-sliders"></i><span>Ajustes</span></a></li>

                </ul>

            </div>

            <div class="sign-off">
                <a href="../login/login.html" class="btn-sign-off">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>


        </div>

        <div class="ds-panel">


        </div>

    </div>

    <script src="../../admin/JS/login/script.js"></script>
    <script>
        function cargarFormulario(ruta) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../../admin/php/" + ruta, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    document.querySelector(".ds-panel").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>

</body>

</html>