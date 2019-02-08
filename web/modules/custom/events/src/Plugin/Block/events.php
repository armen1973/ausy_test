<?php

namespace Drupal\events\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Datetime\Time;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\Entity;

/**
 * Provides a events block.
 * @Block(
 *   id = "events_block",
 *   admin_label = @Translation("Events")
 * )
 */
class Events extends BlockBase
{
    /**
     * Implements Drupal\Core\Block\Blockbase::build().
     */
    public function build($nodetype = NULL)
    {
        //$build = array('#markup' =>$this->t('Welcome!'));
        //return $build;
        $entityid = \Drupal::routeMatch()
            ->getParameter('events_entity')->id();

        $database = \Drupal::database();

        $result = $database
            ->select('events_registered', 'er')
            ->condition('eid',$entityid, '=')
            ->fields('er', [])
            ->execute();

        $resultcount = $database
            ->select('events_registered', 'er')
            ->condition('eid',$entityid, '=')
            ->countQuery()
            ->execute()
            ->fetchField();

        $items = [];
        foreach ($result as $cle) {
            $items[] = $cle->firstName . ' ' . $cle->lasteName;
        }

        $list = [
            '#theme' => 'item_list',
            '#list_type' => 'ul',
            '#items' => $items,
            '#title' => 'Participants ('. $resultcount . ')',
            '#cache' =>
                ['keys' => ['cle_listparticip'],
                    'max-age' => '10',
                ],
            //'#title' => 'Registered user',
        ];

        return [
            'list' => $list,
            '#cache' => [
                'keys' =>['events:particip_list', 'events_type_list'],
                'tags' => ['particip_list'],
                'contexts' => ['url'],
            ],
        ];
    }
}
