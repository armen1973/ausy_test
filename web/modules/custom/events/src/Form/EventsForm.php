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
            '#ajax' => array(
                'callback' => array($this, 'validateTextAjax'),
                'event' => 'change',
            ),
            '#suffix' => '<span id="text-message-valeur1"></span>',
        );

        $form['valeur2'] = array(
            '#type' => 'textfield',
            '#title' => $this
                ->t('Last Name '),
            '#required' => "TRUE",
            '#ajax' => array(
                'callback' => array($this, 'validateTextAjax'),
                'event' => 'change',
            ),
            '#suffix' => '<span id="text-message-valeur"></span>',
        );

        $form['valeur3'] = array(
            '#type' => 'email',
            '#title' => $this
                ->t('E-mail '),
            '#required' => "TRUE",
            '#ajax' => array(
                'callback' => array($this, 'validateTextAjax'),
                'event' => 'change',
            ),
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

    public function ValidateTextAjax(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();

        $field = $form_state->getTriggeringElement()['#name'];

        $value_1_ajax = $form_state->getValue('valeur1');
        if(!is_numeric($value_1_ajax)) {
            $css = ['border' => '2px solid green', 'color' => 'green', 'background' => 'rgba(25, 188, 0,0.2)'];
            $message = $form_state->getValue('valeur1');

        } else {
            $css = ['border' => '2px solid red', 'color' => 'red'];
            $message = 'The value of the field must be a string!';
        }

        //if(!is_numeric($value_1_ajax))

        $response->addCommand(new CssCommand('#edit-valeur1', $css));
        $response->addCommand(new HtmlCommand('#text-message-' . $field, $message)) ;

        return $response;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $valeur1 = $form_state->getValue('valeur1');
        $valeur2 = $form_state->getValue('valeur2');
        $valeur3 = $form_state->getValue('valeur3');
        $current_user = \Drupal::currentUser();
        $userevents = \Drupal\user\Entity\User::load($current_user->id());
        //ksm($userevents->id());
        // Insert the new entity into a fictional table of all entities.
        \Drupal::database()
            ->insert('events_registered')
            ->fields([
                'uid' => $userevents->id(),
                'firstName' => $valeur1,
                'lasteName' => $valeur2,
                'email' => $valeur3,
            ])
            ->execute();

        $result = 'You are registered for the event';
        $form_state->setRebuild()->addRebuildInfo('messageresult', $result);
        $form_state->setRedirect('entity.events_entity.canonical');

    }
}
