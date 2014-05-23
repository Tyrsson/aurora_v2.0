<?php

/**
 * IndexController
 *
 * @author
 * @version
 */

require_once 'System/Controller/Action.php';

class Contact_IndexController extends System_Controller_Action {


	public function init() {
		parent::init();
	}

	/**
	 * The default action - show the home page
	 */
	public function indexAction() {

		$form = new Contact_Form_Contact();
		//$form->setAction($this->_request->url)->setMethod('post');
		if($this->_request->isPost())
		{
			if($form->isValid($this->_request->getPost())) {
				// mail handling
				$mail = new Zend_Mail();
				$this->post = $form->getValues($this->_request->getPost());
				//$result = $this->settings->fetchVar('siteEmail');
				$toEmail = $this->settings->siteEmail;
				$mail->setFrom($this->post['email'], $this->post['name']);
				$message = $this->post['name'] . "\n" . $this->post['email'] . "\n" . $this->post['number'] . "\n" . $this->post['Editor'];

				$mail->setBodyText(strip_tags($message));

				$mail->addTo($toEmail);
				$mail->setSubject('Contact form submission');

				try {
					$send = $mail->send();
					if($send === true) {
						$this->view->messages = array('Your email was sent successfully!');
					} else {
						$this->view->messages = array('There was an unknown error while trying to process your request.');
					}
				} catch (Zend_Exception $e) {
					echo $e->getMessage();
				}


			}

		}

		$this->view->form = $form;
	}
	public function newsletterAction() {

		try {
			$form = new Contact_Form_NewsLetterSignup();
			switch($this->_request->isPost()) {
				case true :
					if($form->isValid($this->_request->getPost())) {
						$data = $form->getValues();
						Zend_Debug::dump($data);
						$db = new Zend_Db_Table('newsletter');
						// both was selected
						if(count($data['type']) == 2) {
							$data['type'] = 'all';
						}
						else {
							// only 1 option was selected
							$data['type'] = array_shift($data['type']);
						}
						$row = $db->fetchNew();
						$row->setFromArray($data);
						$result = $row->save();
						if($result > 0) {
							$this->log->info('Newsletter signup');
						}
					}
					break;
				case false :
					$form->populate( array( 'type' => array( 0 => 'newsletter', 1 => 'offers' ) ) );
					break;
			}
			$this->view->form = $form;
		}
		catch (Zend_Exception $e) {
			$this->log->warn($e);
		}

	}
}
