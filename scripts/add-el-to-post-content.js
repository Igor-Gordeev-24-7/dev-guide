// Разметка прописана в posts-box-content-el.php
document.addEventListener("DOMContentLoaded", () => {
  // Переменные для управления попапом
  const popup = document.getElementById("popup");
  const popupTitle = document.getElementById("popup-title");
  const popupInputsContainer = document.getElementById("popup-inputs");
  const popupSubmit = document.getElementById("popup-submit");
  const popupClose = document.getElementById("popup-close");

  // Проверка на существование элемента
  if (!popupInputsContainer) {
    console.error("Element with id 'popup-inputs' not found");
    return;
  }

  // Кнопки
  const addSubtitleEl = document.getElementById("add-subtitle");
  const addTextEl = document.getElementById("add-text");
  const addLinkEl = document.getElementById("add-link");
  const addCodeEl = document.getElementById("add-code");
  const addYoutubeEl = document.getElementById("add-youtube");
  const addRutubeEl = document.getElementById("add-rutube");
  const addCodepenEl = document.getElementById("add-codepen");
  const addBrEl = document.getElementById("add-br"); // Новая кнопка

  // Текстовое поле для вставки
  const postsContentEl = document.getElementById("posts-content");

  // Объявляем переменную currentCallback
  let currentCallback = null;

  // Функция для отображения попапа
  function showPopup(title, inputs, callback) {
    popup.classList.remove("hidden");
    popupTitle.textContent = title;
    popupInputsContainer.innerHTML = ""; // Очистить контейнер

    // Создаем поля ввода
    inputs.forEach((input, index) => {
      const inputElement = document.createElement("textarea");
      inputElement.className = "popup__textarea";
      inputElement.placeholder = input.placeholder;
      inputElement.dataset.index = index;
      popupInputsContainer.appendChild(inputElement);
    });

    currentCallback = callback; // Сохраняем текущий колбэк
  }

  // Обработчик для кнопки "Добавить"
  popupSubmit.addEventListener("click", () => {
    const inputElements =
      popupInputsContainer.querySelectorAll(".popup__textarea");
    const inputValues = Array.from(inputElements).map((input) =>
      input.value.trim()
    );

    if (inputValues.every((value) => value) && currentCallback) {
      currentCallback(...inputValues);
      popup.classList.add("hidden"); // Закрыть попап
    }
  });

  // Функция закрытия попапа
  popupClose.addEventListener("click", () => {
    popup.classList.add("hidden");
  });

  // Вызов попапа для каждой кнопки
  addSubtitleEl.addEventListener("click", () => {
    showPopup(
      "Подзаголовок",
      [{ placeholder: "Введите подзаголовок" }],
      (input) => {
        const insertText = `
<h3 class="article__subtitle">
  ${input}
</h3>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
        insertTextAtCursor(postsContentEl, insertText);
      }
    );
  });

  addTextEl.addEventListener("click", () => {
    showPopup("Текст", [{ placeholder: "Введите текст" }], (input) => {
      const insertText = `
<p class="article__text">
  ${input}
</p>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
      insertTextAtCursor(postsContentEl, insertText);
    });
  });

  addLinkEl.addEventListener("click", () => {
    showPopup(
      "Ссылка",
      [{ placeholder: "Введите URL" }, { placeholder: "Введите текст ссылки" }],
      (inputUrl, inputText) => {
        const insertLink = `
<a href="${inputUrl}" class="article__link">
  ${inputText}
</a>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
        insertTextAtCursor(postsContentEl, insertLink);
      }
    );
  });

  addCodeEl.addEventListener("click", () => {
    showPopup("Код", [{ placeholder: "Введите код" }], (input) => {
      const escapedInput = escapeHtml(input); // Экранируем HTML-символы
      const insertCode = `
<pre class="article__code">
  <code>
    ${escapedInput}
  </code>
</pre>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
      insertTextAtCursor(postsContentEl, insertCode);
    });
  });

  addYoutubeEl.addEventListener("click", () => {
    showPopup(
      "Видео YouTube",
      [{ placeholder: "Введите ссылку на видео YouTube" }],
      (input) => {
        const insertYoutube = `
<div class="article__iframe-container">
  <iframe class="article__iframe-youtube" src="https://www.youtube.com/embed/${getYouTubeVideoId(
    input
  )}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</div>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
        insertTextAtCursor(postsContentEl, insertYoutube);
      }
    );
  });

  addRutubeEl.addEventListener("click", () => {
    showPopup(
      "Видео Rutube",
      [{ placeholder: "Введите ссылку на видео Rutube" }],
      (input) => {
        const insertRutube = `
<div class="article__iframe-container">
  <iframe class="article__iframe-rutube" src="https://rutube.ru/play/embed/${getRutubeVideoId(
    input
  )}" frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
        insertTextAtCursor(postsContentEl, insertRutube);
      }
    );
  });

  addCodepenEl.addEventListener("click", () => {
    showPopup(
      "Codepen",
      [{ placeholder: "Введите ссылку на Codepen" }],
      (input) => {
        const insertCodepen = `
<iframe height="300" style="width: 100%;" scrolling="no" title="Codepen" src="${getCodepenEmbedUrl(
          input
        )}" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href="${input}">Codepen</a> by <a href="https://codepen.io">Codepen</a>.
</iframe>
      `.trim(); // Удаляем лишние пробелы и переносы строк в начале и конце
        insertTextAtCursor(postsContentEl, insertCodepen);
      }
    );
  });

  // Обработчик для новой кнопки "Добавить перенос строки"
  addBrEl.addEventListener("click", () => {
    const insertBr = "<br><br>";
    insertTextAtCursor(postsContentEl, insertBr);
  });

  // Функция для вставки текста в курсор
  function insertTextAtCursor(targetElement, textToInsert) {
    const cursorPosition = targetElement.selectionStart;
    const beforeCursor = targetElement.value.substring(0, cursorPosition);
    const afterCursor = targetElement.value.substring(cursorPosition);
    targetElement.value = beforeCursor + textToInsert + afterCursor;
    targetElement.selectionStart = targetElement.selectionEnd =
      cursorPosition + textToInsert.length;
    targetElement.focus();
  }

  // Функция для экранирования HTML-символов
  function escapeHtml(str) {
    return str.replace(
      /[&<>"']/g,
      (m) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#39;",
        }[m])
    );
  }

  // Функция для получения ID видео с YouTube
  function getYouTubeVideoId(url) {
    const regex =
      /(?:https?:\/\/)?(?:www\.)?youtu(?:\.be\/|be\.com\/\S*(?:watch|embed)(?:(?:(?=\/[^&\s\?]+(?!\S))\/)|(?:\S*v=|v\/)))([^&\s\?]+)/;
    const match = url.match(regex);
    return match ? match[1] : null;
  }

  // Функция для получения ID видео с Rutube
  function getRutubeVideoId(url) {
    const regex = /(?:https?:\/\/)?(?:www\.)?rutube\.ru\/video\/(\w+)\/?/;
    const match = url.match(regex);
    return match ? match[1] : null;
  }

  // Функция для получения embed URL с Codepen
  function getCodepenEmbedUrl(url) {
    const regex =
      /(?:https?:\/\/)?(?:www\.)?codepen\.io\/([^/]+)\/pen\/([^?]+)/;
    const match = url.match(regex);
    if (match) {
      const username = match[1];
      const penId = match[2];
      return `https://codepen.io/${username}/embed/${penId}?default-tab=html%2Cresult`;
    }
    return null;
  }
});
