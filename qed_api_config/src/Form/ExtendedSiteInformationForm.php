<?php

namespace Drupal\qed_api_config\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);
		$form['site_information']['api_key'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('api_key') ?: 'No API Key yet',
			'#description' => t("Custom field to set the API Key"),
		];
		
		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('system.site')
		  ->set('api_key', $form_state->getValue('api_key'))
		  ->save();
		parent::submitForm($form, $form_state);
	  }
}