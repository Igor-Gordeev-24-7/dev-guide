// highlight.js

export function highlightCodeBlocks(selector) {
  console.log("highlight");
  const parentBlock = document.querySelector(`.${selector}`);
  // Ищем все элементы <pre><code> и применяем к ним highlight.js
  const codeBlocks = parentBlock.querySelectorAll("pre code");
  codeBlocks.forEach((block) => {
    console.log("highlight");
    // Удаляем пробелы и подсвечиваем код
    const lines = block.innerHTML.split("\n");

    // Удаляем пустые строки в начале и в конце
    while (lines.length && lines[0].trim() === "") lines.shift();
    while (lines.length && lines[lines.length - 1].trim() === "") lines.pop();

    // Находим минимальный отступ и удаляем его из всех строк
    const minIndent = lines.reduce((min, line) => {
      const indent = line.match(/^(\s*)/)[0].length;
      return line.trim() ? Math.min(min, indent) : min;
    }, Infinity);

    const trimmedLines = lines.map((line) => line.slice(minIndent));

    block.innerHTML = trimmedLines.join("\n");

    // Подсвечиваем код, используя автоопределение языка
    hljs.highlightElement(block);
  });
}
