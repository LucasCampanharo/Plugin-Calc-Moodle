export const init = () => {
  const screen = document.querySelector("#screen");

  const botoes = document.querySelectorAll("[class^='botao-']");

  botoes.forEach((botao) => {
    botao.addEventListener("click", (e) => {
      let btntext = e.target.innerText;

      // Ignora botões que já têm função separada (onclick inline)
      if (e.target.onclick) return;

      if (btntext === "×") btntext = "*";
      if (btntext === "÷") btntext = "/";
      screen.value += btntext;
    });
  });

  // Funções matemáticas (ligadas ao escopo global para uso inline no HTML)
  window.sin = () => (screen.value = Math.sin(screen.value));
  window.cos = () => (screen.value = Math.cos(screen.value));
  window.tan = () => (screen.value = Math.tan(screen.value));
  window.pow = () => (screen.value = Math.pow(screen.value, 2));
  window.sqrt = () => (screen.value = Math.sqrt(screen.value));
  window.log = () => (screen.value = Math.log(screen.value));
  window.pi = () => (screen.value = 3.141592653589793);
  window.e = () => (screen.value = 2.718281828459045);

  window.fact = () => {
    let num = Number(screen.value);
    let f = 1;
    for (let i = 1; i <= num; i++) f *= i;
    screen.value = f;
  };

  window.backspc = () => {
    screen.value = screen.value.slice(0, -1);
  };
};
