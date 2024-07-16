/* ========================= */
// *! MOSTRAR CARRITO

const btnCart = document.querySelector(".container-cart-icon");
const containerCartProducts = document.querySelector(".container-cart-products");

btnCart.addEventListener("click", () => {
  containerCartProducts.classList.toggle("hidden-cart");
});

/* ========================= */

/* ========================= */
// *! AGREGAR CONTENIDO AL CARRITO

const cartInfo = document.querySelector(".cart-product");
const rowProduct = document.querySelector(".row-product");
const productsList = document.querySelector(".productos-container");

let allProducts = JSON.parse(localStorage.getItem("cart")) || [];

const valorTotal = document.querySelector(".total-pagar");
const countProducts = document.querySelector("#contador-productos");

const cartEmpty = document.querySelector(".cart-empty");
const cartTotal = document.querySelector(".cart-total");

productsList.addEventListener("click", (e) => {
  if (e.target.classList.contains("btn-add-cart")) {
    const product = e.target.parentElement;

    const infoProduct = {
      id: product.querySelector("button").dataset.id,
      quantity: 1,
      title: product.querySelector("h3").textContent,
      price: product.querySelector(".price").textContent,
      image: product.querySelector("img").src,
    };

    const exists = allProducts.some((product) => product.id === infoProduct.id);

    if (exists) {
      const products = allProducts.map((product) => {
        if (product.id === infoProduct.id) {
          product.quantity++;
          return product;
        } else {
          return product;
        }
      });
      allProducts = [...products];
    } else {
      allProducts = [...allProducts, infoProduct];
    }

    updateCart();
    saveToServer(infoProduct, "add");
  }
});

rowProduct.addEventListener("click", (e) => {
  if (e.target.classList.contains("icon-close")) {
    const product = e.target.parentElement;
    const id = product.querySelector(".icon-close").dataset.id;

    allProducts = allProducts.filter((product) => product.id !== id);

    updateCart();
    saveToServer({ id: id }, "remove");
  }
});

const updateCart = () => {
  showHTML();
  localStorage.setItem("cart", JSON.stringify(allProducts));
};

const showHTML = () => {
  if (!allProducts.length) {
    cartEmpty.classList.remove("hidden");
    rowProduct.classList.add("hidden");
    cartTotal.classList.add("hidden");
  } else {
    cartEmpty.classList.add("hidden");
    rowProduct.classList.remove("hidden");
    cartTotal.classList.remove("hidden");
  }

  rowProduct.innerHTML = "";

  let total = 0;
  let totalOfProducts = 0;

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
      <i class="fa-solid fa-xmark icon-close" data-id="${product.id}"></i>
    `;

    rowProduct.append(containerProduct);

    total += parseFloat(product.quantity * parseFloat(product.price.slice(3)));
    totalOfProducts += product.quantity;
  });

  valorTotal.innerText = `S/.${total.toFixed(2)}`;
  countProducts.innerText = totalOfProducts;
};

document.addEventListener("DOMContentLoaded", () => {
  showHTML();
});

const saveToServer = (product, action) => {
  $.ajax({
    url: '../../php/products/update_cart.php',
    type: 'POST',
    data: {
      id: product.id,
      quantity: product.quantity || 0,
      action: action
    },
    success: function(response) {
      console.log(response);
    }
  });
};




