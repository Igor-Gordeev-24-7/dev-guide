// Этот файл содержит JavaScript-код для добавления форматированных HTML-элементов
// (подзаголовков, текста, ссылок, кода) в текстовое поле при нажатии на кнопки.
// Основная цель скрипта — упростить пользователю добавление часто используемых
// HTML-элементов, таких как подзаголовки и ссылки, с автоматическим размещением их
// на текущей позиции курсора внутри текстового поля.

// Переменные для кнопок добавления различных элементов
const addSubtitleEl = document.getElementById("add-subtitle"); // Кнопка для добавления подзаголовка
const addTextEl = document.getElementById("add-text"); // Кнопка для добавления текста
const addLinkEl = document.getElementById("add-link"); // Кнопка для добавления ссылки
const addCodeEl = document.getElementById("add-code"); // Кнопка для добавления блока кода
const addImgEl = document.getElementById("add-img"); // Кнопка для добавления изображения (если нужно)

// Переменная для текстового поля, в которое вставляются HTML-элементы
const postsContentEl = document.getElementById("posts-content"); // Текстовое поле

// HTML-шаблоны для вставки
const insertSubtitle = '<h2 class="article__subtitle">ПОДЗАГОЛОВОК</h2>'; // Шаблон подзаголовка
const insertText = '<p class="article__text">ТЕКСТ</p>'; // Шаблон текста
const insertLink = '<a href="ССЫЛКА" class="article__link">ТЕКСТ</a>'; // Шаблон ссылки
const insertCode = '<pre class="article__code"><code>КОД</code></pre>'; // Шаблон блока кода

// Функция вставки текста в позицию курсора в текстовом поле
// Принимает кнопку, целевое текстовое поле и текст для вставки
function insertTextAtCursor(button, targetElement, textToInsert) {
  if (button) {
    button.addEventListener("click", (e) => {
      e.preventDefault();

      // Определяем текущую позицию курсора
      const cursorPosition = targetElement.selectionStart;

      // Разделяем текстовое содержимое на две части: до и после курсора
      const beforeCursor = targetElement.value.substring(0, cursorPosition);
      const afterCursor = targetElement.value.substring(cursorPosition);

      // Объединяем текст с добавленным шаблоном в позиции курсора
      targetElement.value = beforeCursor + textToInsert + afterCursor;

      // Устанавливаем курсор после вставленного текста
      targetElement.selectionStart = targetElement.selectionEnd =
        cursorPosition + textToInsert.length;

      // Фокусируем текстовое поле для отображения изменений
      targetElement.focus();
    });
  }
}

// Использование функции insertTextAtCursor для каждой кнопки и соответствующего текста
insertTextAtCursor(addSubtitleEl, postsContentEl, insertSubtitle); // Вставка подзаголовка
insertTextAtCursor(addTextEl, postsContentEl, insertText); // Вставка текста
insertTextAtCursor(addLinkEl, postsContentEl, insertLink); // Вставка ссылки
insertTextAtCursor(addCodeEl, postsContentEl, insertCode); // Вставка блока кода
