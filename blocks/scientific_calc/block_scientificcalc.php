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
    background-color: #a0aec0;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.calc-display input {
    background-color: #ffffff;  
    color: #000000; 
    margin-bottom: 5px;            
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    font-size: 20px;
    width: 100%;
}

.calc-btns {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
}

/* Estilo base de botões */
.calc-btns button {
    font-size: 14px;
    border: none;
    border-radius: 10px;
    background: #e0e0e0;
    color: #000;
    box-shadow: 0 2px #999;
    transition: 0.2s;
    padding: 0;
    font-weight: bold;
}

/* Primeiras 5 linhas - botões científicos e secundários */
.calc-btns button:nth-child(-n+25) {
    height: 28px;
    font-size: 12px;
    background: #2f3d4c;      /* azul acinzentado escuro */
    color: #ffffff;
}

/* Botões principais (números e operadores) */
.calc-btns button:nth-child(n+26) {
    height: 42px;
}

/* Botões numéricos */
.calc-btns button:where(:nth-child(n+26):nth-child(-n+35)),
.calc-btns button:where(:nth-child(n+36):nth-child(-n+45)) {
    background: #f8f9fa;      /* cinza claro */
    color: #212529;
}

/* Botões de operação */
button.operator {
    background: #f8f9fa;      
    color: #000;
}

/* Botão limpar */
#calc-clear {
    background: #dc3545;      /* vermelho vibrante */
    color: #fff;
}

/* Botão backspace */
#calc-back {
    background: #dc3545;      
    color: #fff;
}

/* Botões de memória */
button:contains('M+') {
    background: #17a2b8;      /* azul-petróleo */
    color: #fff;
}
button:contains('M-'),
button:contains('MR'),
button:contains('MC'),
button:contains('MS') {
    background: #20c997;      /* verde água */
    color: #fff;
}
</style>



<div class="calc-container" id="calc-container">
    <div class="calc-display">
        <input id="calc_screen" type="text" placeholder="0" />
    </div>

    <div class="calc-btns">
        <button onclick="sin()">sin</button>
        <button onclick="cos()">cos</button>
        <button onclick="tan()">tan</button>
        <button onclick="addToScreen('(')">(</button>
        <button onclick="addToScreen(')')">)</button>

        <button onclick="setAngleMode('deg')">Deg</button>
        <button onclick="setAngleMode('rad')">Rad</button>
        <button onclick="pi()">π</button>
        <button onclick="euler()">e</button>
        <button onclick="fact()">n!</button>

        <button onclick="asin()">sin⁻¹</button>
        <button onclick="acos()">cos⁻¹</button>
        <button onclick="atan()">tan⁻¹</button>
        <button onclick="recip()">1/x</button>
        <button class="operator" onclick="addToScreen('%')">%</button>

        <button onclick="powxy()">xʸ</button>
        <button onclick="pow3()">x³</button>
        <button onclick="pow()">x²</button>
        <button onclick="exp()">eˣ</button>
        <button onclick="pow10()">10ˣ</button>

        <button onclick="rooty()">ʸ√x</button>
        <button onclick="cbrt()">∛x</button>
        <button onclick="sqrt()">√x</button>
        <button onclick="ln()">ln</button>
        <button onclick="log()">log</button>

        <button onclick="addToScreen('7')">7</button>
        <button onclick="addToScreen('8')">8</button>
        <button onclick="addToScreen('9')">9</button>
        <button id="calc-back" onclick="backspc()">DEL</button>
        <button id="calc-clear" onclick="clearScreen()">C</button>

        <button onclick="addToScreen('4')">4</button>
        <button onclick="addToScreen('5')">5</button>
        <button onclick="addToScreen('6')">6</button>
        <button class="operator" onclick="addToScreen('*')">×</button>
        <button class="operator" onclick="addToScreen('/')">÷</button>

        <button onclick="addToScreen('1')">1</button>
        <button onclick="addToScreen('2')">2</button>
        <button onclick="addToScreen('3')">3</button>
        <button class="operator" onclick="addToScreen('+')">+</button>
        <button class="operator" onclick="addToScreen('-')">−</button>

        <button onclick="addToScreen('0')">0</button>
        <button onclick="addToScreen('.')">.</button>
        <button onclick="expEntry()">EXP</button>
        <button onclick="memoryAdd()">M+</button>
        <button id="calc-eval" onclick="calculate()">=</button>
    </div>
</div>

<script>
const screen = document.querySelector("#calc_screen");
let angleMode = "deg";
let pendingOperation = null;
let storedValue = null;
let isResult = false;

// Modos de ângulo
function setAngleMode(mode) {
    angleMode = mode;
    alert("Modo: " + mode.toUpperCase());
}

const toRadians = x => angleMode === "deg" ? x * (Math.PI / 180) : x;
const toDegrees = x => angleMode === "deg" ? x * (180 / Math.PI) : x;

// Entrada de tela
function addToScreen(val) {
    if (isResult) {
        screen.value = "";
        isResult = false;
    }
    screen.value += val;
}

function calculate() {
    try {
        if (pendingOperation && storedValue !== null) {
            const currentValue = eval(screen.value);
            switch (pendingOperation) {
                case "powxy":
                    screen.value = Math.pow(storedValue, currentValue);
                    break;
                case "rooty":
                    screen.value = Math.pow(currentValue, 1 / storedValue);
                    break;
            }
            pendingOperation = null;
            storedValue = null;
            isResult = true;
            return;
        }

        screen.value = eval(screen.value);
        isResult = true;
    } catch {
        screen.value = "Erro";
        isResult = false;
    }
}


function clearScreen() {
    screen.value = "";
    isResult = false;
}

function backspc() {
    screen.value = screen.value.slice(0, -1);
}

// Funções matemáticas com arredondamento
function sin() {
    if (screen.value === "") return;
    screen.value = parseFloat(Math.sin(toRadians(eval(screen.value))).toFixed(10));
    isResult = true;
}
function cos() {
    if (screen.value === "") return;
    screen.value = parseFloat(Math.cos(toRadians(eval(screen.value))).toFixed(10));
    isResult = true;
}
function tan() {
    if (screen.value === "") return;
    screen.value = parseFloat(Math.tan(toRadians(eval(screen.value))).toFixed(10));
    isResult = true;
}
function asin() {
    if (screen.value === "") return;
    screen.value = parseFloat(toDegrees(Math.asin(eval(screen.value))).toFixed(10));
    isResult = true;
}
function acos() {
    if (screen.value === "") return;
    screen.value = parseFloat(toDegrees(Math.acos(eval(screen.value))).toFixed(10));
    isResult = true;
}
function atan() {
    if (screen.value === "") return;
    screen.value = parseFloat(toDegrees(Math.atan(eval(screen.value))).toFixed(10));
    isResult = true;
}

function pow() {
    if (screen.value === "") return;
    screen.value = Math.pow(eval(screen.value), 2);
    isResult = true;
}
function pow3() {
    if (screen.value === "") return;
    screen.value = Math.pow(eval(screen.value), 3);
    isResult = true;
}
function powxy() {
    storedValue = eval(screen.value);
    pendingOperation = "powxy";
    screen.value = "";
}
function sqrt() {
    if (screen.value === "") return;
    screen.value = Math.sqrt(eval(screen.value));
    isResult = true;
}
function cbrt() {
    if (screen.value === "") return;
    screen.value = Math.cbrt(eval(screen.value));
    isResult = true;
}
function rooty() {
    storedValue = eval(screen.value);
    pendingOperation = "rooty";
    screen.value = "";
}
function log() {
    if (screen.value === "") return;
    screen.value = Math.log10(eval(screen.value));
    isResult = true;
}
function ln() {
    if (screen.value === "") return;
    screen.value = Math.log(eval(screen.value));
    isResult = true;
}
function pi() {
    screen.value += Math.PI;
}
function euler() {
    screen.value += Math.E;
}
function exp() {
    if (screen.value === "") return;
    screen.value = Math.exp(eval(screen.value));
    isResult = true;
}
function pow10() {
    if (screen.value === "") return;
    screen.value = Math.pow(10, eval(screen.value));
    isResult = true;
}
function recip() {
    if (screen.value === "") return;
    screen.value = 1 / eval(screen.value);
    isResult = true;
}
function fact() {
    if (screen.value === "") return;
    let n = parseInt(eval(screen.value));
    let f = 1;
    for (let i = 2; i <= n; i++) f *= i;
    screen.value = f;
    isResult = true;
}
function expEntry() {
    screen.value += "e";
}

// Memória
let memory = 0;
function memorySave() { memory = eval(screen.value); }
function memoryRecall() { screen.value += memory; }
function memoryAdd() { memory += eval(screen.value); }
function memorySubtract() { memory -= eval(screen.value); }
function memoryClear() { memory = 0; }
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
