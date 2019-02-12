<?php

namespace Drupal\events\Controller;

use Drupal\Core\Controller\ControllerBase;

class EventsController extends ControllerBase {
    /**
     * @return array
     */
    public function content() {

        return[
            '#theme' => 'mon-template-custom',
            '#test' => 'Test',
        ];
    }
}

