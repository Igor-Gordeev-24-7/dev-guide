console.log("1");

export const BASE_URL = "http://localhost:8888/";

document.addEventListener("DOMContentLoaded", function () {
  // Находим все элементы с классом 'submenu-open-el'
  const submenuOpenElements = document.querySelectorAll(".submenu-open-el");

  // Функция для открытия подменю
  function openSubmenu(event) {
    // Находим подменю внутри текущего элемента
    const submenu = this.querySelector(".submenu");

    // Проверяем, существует ли подменю
    if (submenu) {
      // Закрываем все другие подменю перед открытием текущего
      document.querySelectorAll(".submenu").forEach((submenuEl) => {
        if (submenuEl !== submenu) {
          submenuEl.classList.remove("active");
        }
      });

      // Открываем текущее подменю
      submenu.classList.add("active");
    }
  }

  // Функция для закрытия подменю
  function closeSubmenu(event) {
    // Находим подменю внутри текущего элемента
    const submenu = this.querySelector(".submenu");

    // Проверяем, существует ли подменю
    if (submenu) {
      // Закрываем текущее подменю
      submenu.classList.remove("active");
    }
  }

  // Добавляем обработчики событий для каждого элемента с классом 'submenu-open-el'
  submenuOpenElements.forEach((el) => {
    // Открываем подменю при наведении курсора
    el.addEventListener("mouseover", openSubmenu);

    // Закрываем подменю при уходе курсора
    el.addEventListener("mouseout", closeSubmenu);
  });
});
