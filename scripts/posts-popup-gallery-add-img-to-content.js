/**
 * Скрипт для работы с модальным окном галереи изображений.
 *
 * 1. Открытие модального окна с галереей изображений при клике на кнопку.
 * 2. Закрытие модального окна при клике на кнопку "крестик" или за пределами окна.
 * 3. Вставка изображения из галереи на позицию курсора в поле ввода.
 *
 * Функции:
 * - `initImageGalleryModal`: инициализирует функциональность галереи, открывает и закрывает модальное окно,
 *    вставляет выбранное изображение в поле ввода.
 * - `insertAtCursor`: вставляет переданный HTML-код в текстовое поле на текущую позицию курсора.
 *
 * Используемые переменные:
 * - `BASE_URL`: используется для формирования пути к изображениям на сервере.
 *
 * Требуемые элементы HTML:
 * - Кнопка с ID "add-img" для открытия галереи.
 * - Модальное окно с ID "posts-gallary".
 * - Кнопка с ID "gallery-close" для закрытия модального окна.
 * - Все изображения в галерее имеют класс "posts__gallery-item".
 * - Поле ввода для вставки изображений с ID "posts-content".
 */

import { BASE_URL } from "./script.js";

/**
 * Функция для инициализации модального окна с галереей изображений.
 * @param {string} triggerId - ID кнопки, открывающей модальное окно.
 * @param {string} popupId - ID модального окна с галереей.
 * @param {string} closeButtonId - ID кнопки закрытия модального окна.
 * @param {string} galleryItemClass - Класс для изображений в галерее.
 * @param {string} contentId - ID поля, в которое будут вставляться изображения.
 */
function initImageGalleryModal(
  triggerId,
  popupId,
  closeButtonId,
  galleryItemClass,
  contentId
) {
  const popupEl = document.getElementById(popupId); // Модальное окно с галереей
  const triggerIdEl = document.getElementById(triggerId); // Кнопка открытия модального окна
  const popupCloseEl = document.getElementById(closeButtonId); // Кнопка закрытия модального окна
  const activeClass = "active"; // Класс для активации модального окна

  // Открытие модального окна при клике на triggerIdEl
  triggerIdEl.addEventListener("click", () => {
    popupEl.classList.add(activeClass);
  });

  // Закрытие модального окна при клике на кнопку "крестик"
  if (popupCloseEl) {
    popupCloseEl.addEventListener("click", () => {
      popupEl.classList.remove(activeClass);
    });
  }

  // Закрытие модального окна при клике за его пределами
  window.onclick = function (event) {
    if (event.target === popupEl) {
      popupEl.classList.remove(activeClass);
    }
  };

  // Находим все изображения внутри модального окна (popupEl)
  const galleryItemsImg = popupEl.querySelectorAll(galleryItemClass);

  // Устанавливаем обработчик клика на каждое изображение
  galleryItemsImg.forEach((itemImg) => {
    itemImg.addEventListener("click", () => {
      // Поле ввода, куда будет вставлено изображение
      const postsContentEl = document.getElementById(contentId);

      // Формируем HTML-код изображения, используя BASE_URL для пути
      const imageHtml = `
<img src="${BASE_URL}assets/uploads/${itemImg.getAttribute("alt")}"
alt="${itemImg.alt}" class="article__img preview-img">`;

      // Вставка изображения на позицию курсора в поле ввода
      insertAtCursor(postsContentEl, imageHtml);

      // Закрытие модального окна после выбора изображения
      popupEl.classList.remove(activeClass);
    });
  });
}

/**
 * Функция для вставки HTML-кода изображения на позицию курсора в текстовом поле
 * @param {HTMLElement} textArea - Текстовое поле, куда вставляется изображение
 * @param {string} text - HTML-код изображения для вставки
 */
function insertAtCursor(textArea, text) {
  const start = textArea.selectionStart; // Начальная позиция выделения
  const end = textArea.selectionEnd; // Конечная позиция выделения

  // Вставляем текст на позицию курсора
  textArea.value =
    textArea.value.substring(0, start) + text + textArea.value.substring(end);

  // Перемещаем курсор после вставленного текста
  textArea.selectionStart = textArea.selectionEnd = start + text.length;

  // Фокусируемся на элементе после вставки
  textArea.focus();
}

// Инициализация модального окна с галереей
document.addEventListener("DOMContentLoaded", function () {
  initImageGalleryModal(
    "add-img", // ID кнопки открытия галереи
    "posts-gallary", // ID модального окна с галереей
    "gallery-close", // ID кнопки закрытия галереи
    ".posts__gallery-item img", // Класс для изображений в галерее
    "posts-content" // ID поля для вставки изображений
  );
});
