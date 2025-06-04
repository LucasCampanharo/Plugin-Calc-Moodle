<?php
class block_scientificcalc extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_scientificcalc');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = $this->render();

        return $this->content;
    }

    public function render() {
        return <<<HTML
<style>
.calc-container {
    margin-left: 1em;
    padding: 12px;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    color: #000000;
    max-width: 240px;
}

.calc-display #calc_screen {
    margin-bottom: 0.8em;
    width: 100%;
    height: 50px;
    font-size: 20px;
    text-align: right;
    padding-right: 0.4em;
    background: #f0f0f0;
    color: #000000;
    border: none;
    border-radius: 6px;
    box-shadow: inset 2px 2px 5px #ccc, inset -2px -2px 5px #fff;
}

.calc-btns {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 6px;
}

.calc-btns button {
    height: 38px;
    font-size: 14px;
    border: none;
    border-radius: 6px;
    background: #f3f3f3;
    color: #000;
    box-shadow: 1px 1px 3px #ccc, -1px -1px 3px #fff;
    transition: 0.2s;
    padding: 0;
}

.calc-btns button:hover {
    filter: brightness(90%);
}

#calc-eval {
    background: #00bfff;
    color: #fff;
}

#calc-eval:hover {
    background: #009acd;
}

#calc-ac {
    background: #00cc66;
    color: #fff;
}

#calc-ac:hover {
    background: #00994d;
}

#calc-ce {
    background: #ff3399;
    color: #fff;
}

#calc-ce:hover {
    background: #cc0066;
}
</style>

<div class="calc-container" id="calc-container">
    <div class="calc-display">
        <input id="calc_screen" type="text" placeholder="0" />
    </div>

    <div class="calc-btns">
        <button onclick="pow()">x²</button>
        <button onclick="pi()">π</button>
        <button onclick="euler()">e</button>
        <button id="calc-ac" onclick="calc_screen.value=''">C</button>
        <button id="calc-ce" onclick="backspc()">⌫</button>

        <button onclick="sqrt()">√</button>
        <button>(</button>
        <button>)</button>
        <button onclick="fact()">n!</button>
        <button>/</button>

        <button onclick="sin()">sin</button>
        <button>7</button>
        <button>8</button>
        <button>9</button>
        <button>*</button>

        <button onclick="cos()">cos</button>
        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>-</button>

        <button onclick="tan()">tan</button>
        <button>1</button>
        <button>2</button>
        <button>3</button>
        <button>+</button>

        <button onclick="log()">log</button>
        <button>0</button>
        <button>.</button>
        <button id="calc-eval" onclick="calc_screen.value=eval(calc_screen.value)">=</button>
    </div>
</div>

<script>
(function() {
    const screen = document.querySelector("#calc_screen");
    const botoes = document.querySelectorAll(".calc-btns button");

    botoes.forEach((botao) => {
        botao.addEventListener("click", (e) => {
            let btntext = e.target.innerText;
            if (e.target.getAttribute("onclick")) return;

            if (btntext === "×") btntext = "*";
            if (btntext === "÷") btntext = "/";
            screen.value += btntext;
        });
    });

    window.sin = () => screen.value = Math.sin(screen.value);
    window.cos = () => screen.value = Math.cos(screen.value);
    window.tan = () => screen.value = Math.tan(screen.value);
    window.pow = () => screen.value = Math.pow(screen.value, 2);
    window.sqrt = () => screen.value = Math.sqrt(screen.value);
    window.log = () => screen.value = Math.log(screen.value);
    window.pi = () => screen.value += Math.PI;
    window.euler = () => screen.value += 2.718281828459045;
    window.fact = () => {
        let num = Number(screen.value);
        let f = 1;
        for (let i = 1; i <= num; i++) f *= i;
        screen.value = f;
    };
    window.backspc = () => screen.value = screen.value.slice(0, -1);
})();
</script>
HTML;
    }

    public function applicable_formats() {
        return ['all' => true];
    }

    public function instance_allow_multiple() {
        return false;
    }
}
