<?php
class block_scientificcalc extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_scientificcalc');
    }

    public function get_content() {
        global $PAGE, $OUTPUT; // <- Adiciona $OUTPUT aqui

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = $this ->render();
        $this->content->footer = '';

       

        return $this->content;
    }

private function render() {
    return `
    <div class="container scientificcalc-container">
  <div class="display">
    <input id="screen" type="text" placeholder="0" />
  </div>

  <div class="btns">
    <div class="row">
      <button id="ce" class="botao-funcao" onclick="backspc()">⌫</button>
      <button class="botao-funcao" onclick="fact()">n!</button>
      <button class="botao-parenteses">(</button>
      <button class="botao-parenteses">)</button>
      <button class="botao-operador">%</button>
      <button id="ac" class="botao-funcao" onclick="screen.value=''">CE</button>
    </div>

    <div class="row">
      <button class="botao-funcao" onclick="sin()">sin</button>
      <button class="botao-constante" onclick="pi()">π</button>
      <button class="botao-numero">7</button>
      <button class="botao-numero">8</button>
      <button class="botao-numero">9</button>
      <button class="botao-operador">÷</button>
    </div>

    <div class="row">
      <button class="botao-funcao" onclick="cos()">cos</button>
      <button class="botao-constante" onclick="e()">e</button>
      <button class="botao-numero">4</button>
      <button class="botao-numero">5</button>
      <button class="botao-numero">6</button>
      <button class="botao-operador">×</button>
    </div>

    <div class="row">
      <button class="botao-funcao" onclick="tan()">tan</button>
      <button class="botao-funcao" onclick="sqrt()">√</button>
      <button class="botao-numero">1</button>
      <button class="botao-numero">2</button>
      <button class="botao-numero">3</button>
      <button class="botao-operador">-</button>
    </div>

    <div class="row">
      <button class="botao-funcao" onclick="log()">log</button>
      <button class="botao-funcao" onclick="pow()">x²</button>
      <button class="botao-numero">0</button>
      <button class="botao-numero">.</button>
      <button id="eval" class="botao-igual" onclick="screen.value=eval(screen.value)">=</button>
      <button class="botao-operador">+</button>
    </div>
  </div>
</div>
<script> 
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
</script>
`;
}

    public function applicable_formats() {
        return ['all' => true];
    }

    public function instance_allow_multiple() {
        return false;
    }
}
