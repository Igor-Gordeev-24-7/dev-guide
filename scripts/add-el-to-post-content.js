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
});
