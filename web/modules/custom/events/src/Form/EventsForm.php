<?php

namespace Drupal\events\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Database\DatabaseExceptionWrapper;

class EventsForm extends FormBase {

    /**
     *{@inheritdoc}
     */
    public function getFormId()
    {
        return 'Events_Form';
    }

    /**
     *{@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        if(isset($form_state->getRebuildInfo()['messageresult'])) {
        $messageresult = $form_state->getRebuildInfo()['messageresult'];

            $form['messageresult'] = [
                '#markup' =>$this->t('%messageresult',
                    ['%messageresult' => $messageresult]),
            ];
        }

        $form['valeur1'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('First Name '),
            '#required' => "TRUE",
            '#suffix' => '<span id="text-message-valeur1"></span>',
        );

        $form['valeur2'] = array(
            '#type' => 'textfield',
            '#title' => $this
                ->t('Last Name '),
            '#required' => "TRUE",
            '#suffix' => '<span id="text-message-valeur"></span>',
        );

        $form['valeur3'] = array(
            '#type' => 'email',
            '#title' => $this
                ->t('E-mail '),
            '#required' => "TRUE",
            '#suffix' => '<span id="text-message-valeur"></span>',
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this
                ->t('S\'inscrire'),
        );

        return $form;
    }

    /**
     *{@inheritdoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        $value_1 = $form_state->getValue('valeur1');
        if(is_numeric($value_1)) {
            $form_state->setErrorByName('valeur1', $this->t('The value of the field must be a string!'));
        }
        $value_2 = $form_state->getValue('valeur2');

        if(is_numeric($value_2)) {
            $form_state->setErrorByName('valeur2', $this->t('The value of the field must be a string!'));
        }

        if(isset($form['messageresult'])) {
            unset($form['messageresult']);
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $entityid = \Drupal::routeMatch()
            ->getParameter('events_entity')->id();
        $database = \Drupal::database();
        $checkmail = $database
            ->select('events_registered', 'er')
            ->condition('eid',$entityid, '=')
            ->fields('er', ['email'])
            ->execute();

        $items = [];
        foreach ($checkmail as $clemail) {
            $items[] = $clemail->email;
        }

        $valeur1 = $form_state->getValue('valeur1');
        $valeur2 = $form_state->getValue('valeur2');
        $valeur3 = $form_state->getValue('valeur3');
        $current_user = \Drupal::currentUser();
        $userevents = \Drupal\user\Entity\User::load($current_user->id());
        $entityid = \Drupal::routeMatch()->getParameter('events_entity')->id();

        if(!in_array($valeur3, $items)) {
            // Insert the new entity into a fictional table of all entities.
            \Drupal::database()
                ->insert('events_registered')
                ->fields([
                    'uid' => $userevents->id(),
                    'eid' => $entityid,
                    'firstName' => $valeur1,
                    'lasteName' => $valeur2,
                    'email' => $valeur3,
                ])
                ->execute();
            //$result = 'You are registered for the event';
            //$form_state->setRebuild()->addRebuildInfo('messageresult', $result);
            $form_state->setRedirect('entity.events_entity.canonical', ['events_entity' => $entityid, 'check' => 1]);
        }
    }
}
