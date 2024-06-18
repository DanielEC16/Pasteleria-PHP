const btnMenu = document.querySelector(".btn-menu");
const buttonLeftRight = document.querySelector(".btn-menu .fa-solid");

// Un addEventListener en este contexto es una acción que ocurre en el DOM (Modelo de Objetos del Documento), como hacer clic en un botón, pasar el ratón sobre un elemento, enviar un formulario, etc.

btnMenu.addEventListener("click", () => {

  // toggle() : Método que se utiliza para alternar la presencia de una clase en el conjunto de clases del elemento.
  
  buttonLeftRight.classList.toggle("fa-circle-chevron-left");
  buttonLeftRight.classList.toggle("fa-circle-chevron-right");

  
  document.querySelector(".ds-left-menu").classList.toggle("menu-active");
  document.querySelector(".ds-panel").classList.toggle("tab-menu");
});

// scripts.js

// Obtener todos los enlaces del menú
const menuItems = document.querySelectorAll('.ds-menu ul li a');

// Obtener todos los elementos de contenido
const contentDivs = document.querySelectorAll('.content');

// Función para manejar el clic en el menú
function handleMenuClick(event) {
    event.preventDefault();

    // Obtener el enlace en el que se hizo clic
    const targetElement = event.target.closest('a');

    if (!targetElement) return; // Si no es un <a>, salir

    const targetId = targetElement.getAttribute('data-target');

    if (!targetId) return; // Si no tiene data-target, salir

    // Ocultar todos los divs de contenido
    contentDivs.forEach(div => {
        div.classList.remove('active');
    });

    // Mostrar el div correspondiente
    const targetDiv = document.getElementById(targetId);
    if (targetDiv) {
        targetDiv.classList.add('active');
    }
}

// Agregar eventos de clic a todos los enlaces del menú
menuItems.forEach(item => {
    item.addEventListener('click', handleMenuClick);
});


document.addEventListener('DOMContentLoaded', function() {
  // Obtener todos los botones que muestran modales
  const btnMostrarModal = document.querySelectorAll('.btnMostrarModal');

  // Agregar evento click a cada botón
  btnMostrarModal.forEach(btn => {
      btn.addEventListener('click', function() {
          const targetModalId = this.getAttribute('data-target');
          const modal = document.getElementById(targetModalId);

          // Mostrar el modal correspondiente
          if (modal) {
              modal.style.display = 'block';
          }
      });
  });

  // Agregar evento click para cerrar los modales
  const cerrarModales = document.querySelectorAll('.cerrar-modal');

  cerrarModales.forEach(btn => {
      btn.addEventListener('click', function() {
          const modal = this.closest('.modal');
          if (modal) {
              modal.style.display = 'none';
          }
      });
  });

  // Cerrar modal al hacer clic fuera del contenido
  window.addEventListener('click', function(event) {
      if (event.target.classList.contains('modal')) {
          event.target.style.display = 'none';
      }
  });
});   




