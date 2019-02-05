<?php

namespace Drupal\events\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Datetime\Time;
use Drupal\user\UserInterface;

/**
 * Provides a events block.
 * @Block(
 *   id = "events_block",
 *   admin_label = @Translation("Events")
 * )
 */
class Events extends BlockBase {

    /**
     * Implements Drupal\Core\Block\Blockbase::build().
     */

    public function build() {

        //$build = array('#markup' =>$this->t('Welcome!'));
        //return $build;

        $database = \Drupal::database();
        $result = $database->select('events_registered', 'er')
            ->fields('er', [])
            ->execute();

        $items = [];
        foreach($result as $cle) {
            $items[] = $cle->firstName .' '. $cle->lasteName;
        }
        $list = [
            '#theme' => 'item_list',
            '#list_type'=>'ul',
            '#items' => $items,
            '#title' => 'Registered user',
        ];
        return $list;
    }
}
