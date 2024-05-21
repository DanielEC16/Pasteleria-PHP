const btnMenu = document.querySelector(".btn-menu");
const buttonLeftRight = document.querySelector(".btn-menu .fa-solid");

btnMenu.addEventListener("click", () => {
    buttonLeftRight.classList.toggle("fa-circle-chevron-left");
    buttonLeftRight.classList.toggle("fa-circle-chevron-right");
    
  document.querySelector(".ds-left-menu").classList.toggle("menu-active");
  document.querySelector(".ds-panel").classList.toggle("tab-menu");
});
