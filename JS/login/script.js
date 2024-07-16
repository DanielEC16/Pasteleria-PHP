


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


document.addEventListener('DOMContentLoaded', function() {
  // Obtener todos los elementos <a> dentro de <li>
  const links = document.querySelectorAll('.ds-menu ul li a');

  // Agregar evento de clic a cada enlace
  links.forEach(link => {
      link.addEventListener('click', function(e) {
          e.preventDefault(); // Prevenir el comportamiento por defecto del enlace

          const target = this.getAttribute('data-target'); // Obtener el valor de data-target

          // Ocultar todos los contenidos dentro de ds-panel
          const contents = document.querySelectorAll('.ds-panel .content');
          contents.forEach(content => {
              content.style.display = 'none';
          });

          // Mostrar solo el contenido con el id correspondiente a data-target
          const selectedContent = document.getElementById(target);
          if (selectedContent) {
              selectedContent.style.display = 'block';
          }
      });
  });
});