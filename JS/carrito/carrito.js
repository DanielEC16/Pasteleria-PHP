/* ========================= */
// *!  MOSTRAR CARRITO

// Selecciona el ícono del carrito y el contenedor del carrito
const btnCart = document.querySelector(".container-cart-icon");
const containerCartProducts = document.querySelector(
  ".container-cart-products"
);

// Añade un evento de clic al ícono del carrito para mostrar/ocultar el contenedor del carrito
btnCart.addEventListener("click", () => {
  containerCartProducts.classList.toggle("hidden-cart");
});

/* ========================= */

/* ========================= */
// *! AGREGAR CONTENIDO AL CARRITO

// Selecciona elementos del carrito
const cartInfo = document.querySelector(".cart-product");
const rowProduct = document.querySelector(".row-product");

// Selecciona el contenedor de productos
const productsList = document.querySelector(".productos-container");

// Inicializa el arreglo de productos con los datos del carrito almacenados en localStorage (si existen)
let allProducts = JSON.parse(localStorage.getItem("cart")) || [];

// Selecciona los elementos para mostrar el total y la cantidad de productos en el carrito
const valorTotal = document.querySelector(".total-pagar");
const countProducts = document.querySelector("#contador-productos");

// Selecciona elementos para mostrar/ocultar mensajes de carrito vacío y total del carrito
const cartEmpty = document.querySelector(".cart-empty");
const cartTotal = document.querySelector(".cart-total");

// Añade un evento de clic a la lista de productos
productsList.addEventListener("click", (e) => {
  // Verifica si el clic se realizó en un botón de agregar al carrito
  if (e.target.classList.contains("btn-add-cart")) {
    const product = e.target.parentElement;

    // Obtiene la información del producto
    const infoProduct = {
      quantity: 1,
      title: product.querySelector("h3").textContent,
      price: product.querySelector(".price").textContent,
      image: product.querySelector("img").src,
    };

    // Verifica si el producto ya existe en el carrito
    const exists = allProducts.some(
      (product) => product.title === infoProduct.title
    );

    // Si el producto existe, incrementa su cantidad
    if (exists) {
      const products = allProducts.map((product) => {
        if (product.title === infoProduct.title) {
          product.quantity++;
          return product;
        } else {
          return product;
        }
      });
      allProducts = [...products];
    } else {
      // Si el producto no existe, lo añade al arreglo de productos
      allProducts = [...allProducts, infoProduct];
    }

    // Actualiza el carrito y guarda los cambios en localStorage
    updateCart();
  }
});

// Añade un evento de clic a la fila de productos en el carrito
rowProduct.addEventListener("click", (e) => {
  // Verifica si el clic se realizó en un ícono de cerrar
  if (e.target.classList.contains("icon-close")) {
    const product = e.target.parentElement;
    const title = product.querySelector("p").textContent;

    // Filtra los productos para eliminar el producto seleccionado
    allProducts = allProducts.filter((product) => product.title !== title);

    // Actualiza el carrito y guarda los cambios en localStorage
    updateCart();
  }
});

// Función para actualizar el carrito y guardar en localStorage
const updateCart = () => {
  showHTML();
  localStorage.setItem("cart", JSON.stringify(allProducts));
};

// Función para mostrar el HTML del carrito
const showHTML = () => {
  // Muestra u oculta mensajes según si el carrito está vacío o no
  if (!allProducts.length) {
    cartEmpty.classList.remove("hidden");
    rowProduct.classList.add("hidden");
    cartTotal.classList.add("hidden");
  } else {
    cartEmpty.classList.add("hidden");
    rowProduct.classList.remove("hidden");
    cartTotal.classList.remove("hidden");
  }

  // Limpia el contenido del carrito
  rowProduct.innerHTML = "";

  let total = 0;
  let totalOfProducts = 0;

  // Recorre los productos del carrito y genera el HTML correspondiente
  allProducts.forEach((product) => {
    const containerProduct = document.createElement("div");
    containerProduct.classList.add("cart-product");

    containerProduct.innerHTML = `
      <div class="info-cart-product">
          <img src="${product.image}" alt="${product.title}" class="product-image-cart">
          <span class="cantidad-producto-carrito">${product.quantity}</span>
          <p class="titulo-producto-carrito">${product.title}</p>
          <span class="precio-producto-carrito">${product.price}</span>
      </div>
      <i class="fa-solid fa-xmark icon-close"></i>
    `;

    rowProduct.append(containerProduct);

    // Calcula el total y la cantidad de productos
    total += parseFloat(product.quantity * parseFloat(product.price.slice(3)));
    totalOfProducts += product.quantity;
  });

  // Actualiza el total y la cantidad de productos en el carrito
  valorTotal.innerText = `$${total.toFixed(2)}`;
  countProducts.innerText = totalOfProducts;
};

// Cargar el carrito desde localStorage al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  showHTML();
});


