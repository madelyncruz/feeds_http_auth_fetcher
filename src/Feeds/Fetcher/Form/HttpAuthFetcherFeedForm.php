<?php

namespace Drupal\feeds_http_auth_fetcher\Feeds\Fetcher\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\feeds\FeedInterface;
use Drupal\feeds\Feeds\Fetcher\Form\HttpFetcherFeedForm;

/**
 * Provides a form on the feed edit page for the HttpFetcher.
 */
class HttpAuthFetcherFeedForm extends HttpFetcherFeedForm {

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration()
    {
        $defaults = parent::defaultConfiguration();
    }


  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FeedInterface $feed = NULL) {
      parent::buildConfigurationForm($form, $form_state, $feed);

      $form['source'] = [
          '#title' => $this->t('Feed URL'),
          '#type' => 'url',
          '#default_value' => $feed->getSource(),
          '#maxlength' => 2048,
          '#required' => TRUE,
      ];
      $form['token'] = [
          '#title' => $this->t('Authorization Header Token:'),
          '#description' => "The optional bearer token to provide for an <strong>Authorization</strong> HTTP header.",
          '#type' => 'textfield',
          '#default_value' => $feed->getConfigurationFor($this->plugin)['token'],
          '#maxlength' => 255,
      ];

    return $form;
  }
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state, FeedInterface $feed = NULL)
    {
        $feed_config = $feed->getConfigurationFor($this->plugin);
        $feed_config['token'] = $form_state->getValue('token');
        $feed->setConfigurationFor($this->plugin, $feed_config);
    }
}
