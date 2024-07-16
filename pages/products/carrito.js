document.addEventListener("DOMContentLoaded", () => {
    const botonesMas = document.querySelectorAll(".btn-mas");
    const botonesMenos = document.querySelectorAll(".btn-menos");
    const totalElement = document.getElementById("total");
    const realizarPedidoBtn = document.getElementById("realizar-pedido");

    botonesMas.forEach(boton => {
        boton.addEventListener("click", () => {
            const producto = boton.closest('.producto-carrito');
            actualizarCantidad(producto, 1);
        });
    });

    botonesMenos.forEach(boton => {
        boton.addEventListener("click", () => {
            const producto = boton.closest('.producto-carrito');
            actualizarCantidad(producto, -1);
        });
    });

    realizarPedidoBtn.addEventListener("click", () => {
        realizarPedido();
    });

    function actualizarCantidad(producto, cambio) {
        const cantidadElement = producto.querySelector(".cantidad");
        let cantidad = parseInt(cantidadElement.textContent) + cambio;

        if (cantidad > 0) {
            cantidadElement.textContent = cantidad;
            const precioElement = producto.querySelector(".precio");
            const precio = parseFloat(precioElement.textContent);
            const nuevoSubtotal = precio * cantidad;
            producto.querySelector(".subtotal").textContent = nuevoSubtotal.toFixed(2);
            actualizarTotal();
        }
    }

    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll(".subtotal").forEach(subtotal => {
            total += parseFloat(subtotal.textContent);
        });
        totalElement.textContent = total.toFixed(2);
    }

    function realizarPedido() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../php/products/realizar_pedido.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    alert(response.message);
                    // Redireccionar o realizar alguna acción después de completar el pedido
                } else {
                    alert(response.message);
                }
            }
        };

        xhr.send();
    }
});
