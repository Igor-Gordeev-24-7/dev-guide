// Этот скрипт предназначен для инициализации модального окна (popup),
// которое позволяет пользователю просматривать увеличенные изображения при клике на них.
// При клике на изображение с классом preview-img открывается модальное окно с этим изображением.
// Окно можно закрыть нажатием на крестик или кликом за пределы изображения.

// Инициализация popup с переданными элементами
function initPopup(popupId, previewImgClass, popupImgId, closeBtnClass) {
  const popup = document.getElementById(popupId); // Модальное окно
  const formPreviewImgEls = document.querySelectorAll(`.${previewImgClass}`); // Изображения с классом preview-img
  const popupImg = document.getElementById(popupImgId); // Изображение внутри модального окна
  const postsPopupCloseEl = document.querySelector(`.${closeBtnClass}`); // Кнопка закрытия popup

  // Функция для открытия popup с выбранным изображением
  function openPopup(imgSrc) {
    popup.style.display = "block"; // Отображаем popup
    popupImg.src = imgSrc; // Устанавливаем src изображения, по которому кликнули
  }

  // Функция для закрытия popup
  function closePopup() {
    popup.style.display = "none"; // Скрываем popup
  }

  // Устанавливаем обработчик клика на каждое изображение для открытия popup
  formPreviewImgEls.forEach(function (imgEl) {
    imgEl.onclick = function () {
      openPopup(imgEl.src); // Передаем src изображения, по которому кликнули
    };
  });

  // Устанавливаем обработчик клика на крестик для закрытия popup
  if (postsPopupCloseEl) {
    postsPopupCloseEl.onclick = closePopup;
  }

  // Закрытие popup при клике за его пределы
  window.onclick = function (event) {
    if (event.target === popup) {
      closePopup();
    }
  };
}

// Вызов инициализации popup после загрузки содержимого страницы
document.addEventListener("DOMContentLoaded", function () {
  // Передаем ID и классы элементов в функцию
  initPopup("popup", "preview-img", "popupImg", "popup-close");
});

/*
Пример разметки HTML для этого скрипта:

<div class="posts__form-preview">
  <img class="posts__form-preview-img preview-img" src="<?=$img?>"
      alt="Превью изображения" style="max-width: 200px; height: auto;">
</div>

<div id="popup" class="posts__popup" style="display: none;">
  <span class="posts__popup-close popup-close" id="popupClose">&times;</span>
  <img class="posts__popup-img" id="popupImg" alt="Превью изображения" />
</div>
*/
