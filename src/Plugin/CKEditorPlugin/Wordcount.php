<?php

/**
 * @file
 * Contains \Drupal\ckwordcount\Plugin\CKEditorPlugin\Wordcount.
 */

namespace Drupal\ckwordcount\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\ckeditor\CKEditorPluginContextualInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "wordcount" plugin.
 *
 * @CKEditorPlugin(
 *   id = "wordcount",
 *   label = @Translation("Word Count & Character Count")
 * )
 */
class Wordcount extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface, CKEditorPluginContextualInterface {
  /**
   * {@inheritdoc}
   */
  public function getDependencies(Editor $editor) {
    return ['notification'];
  }
  
  public function getButtons() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return '/libraries/wordcount/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled(Editor $editor) {
    $settings = $editor->getSettings();
    return (bool) $settings['plugins']['wordcount']['enable'];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    $settings = $editor->getSettings();

    return [
      'wordcount' => [
        'showParagraphs' => !empty($settings['plugins']['wordcount']['show_paragraphs']) ? $settings['plugins']['wordcount']['show_paragraphs'] : false,
        'showWordCount' => !empty($settings['plugins']['wordcount']['show_word_count']) ? $settings['plugins']['wordcount']['show_word_count'] : false,
        'showCharCount' => !empty($settings['plugins']['wordcount']['show_char_count']) ? $settings['plugins']['wordcount']['show_char_count'] : false,
        'countSpacesAsChars' => !empty($settings['plugins']['wordcount']['count_spaces']) ? $settings['plugins']['wordcount']['count_spaces'] : false,
        'countHTML' => !empty($settings['plugins']['wordcount']['count_html']) ? $settings['plugins']['wordcount']['count_html'] : false,
        'maxWordCount' => -1,
        'maxCharCount' => -1
      ]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    $settings = $editor->getSettings();

    $form['enable'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable the counter'),
      '#default_value' => !empty($settings['plugins']['wordcount']['enable']) ? $settings['plugins']['wordcount']['enable'] : false,
    );

    $form['show_paragraphs'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Show the paragraphs count'),
      '#default_value' => !empty($settings['plugins']['wordcount']['show_paragraphs']) ? $settings['plugins']['wordcount']['show_paragraphs'] : false,
    );


    $form['show_word_count'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Show the word count'),
      '#default_value' => !empty($settings['plugins']['wordcount']['show_word_count']) ? $settings['plugins']['wordcount']['show_word_count'] : false,
    );

    $form['show_char_count'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Show the character count'),
      '#default_value' => !empty($settings['plugins']['wordcount']['show_char_count']) ? $settings['plugins']['wordcount']['show_char_count'] : false,
    );

    $form['count_spaces'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Count spaces as characters'),
      '#default_value' => !empty($settings['plugins']['wordcount']['count_spaces']) ? $settings['plugins']['wordcount']['count_spaces'] : false,
    );

    $form['count_html'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Count HTML as characters'),
      '#default_value' => !empty($settings['plugins']['wordcount']['count_html']) ? $settings['plugins']['wordcount']['count_html'] : false,
    );

    return $form;
  }
}