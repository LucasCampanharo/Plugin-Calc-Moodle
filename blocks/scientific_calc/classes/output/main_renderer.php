<?php
namespace block_scientificcalc\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use stdClass;

class main_renderer extends plugin_renderer_base {

    public function render_calculator() {
        $data = new stdClass();
        // Adicione variáveis que queira passar para o template aqui
        return $this->render_from_template('block_scientificcalc/content', $data);
    }
}
