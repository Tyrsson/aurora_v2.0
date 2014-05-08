<?php
class User_Form_Register extends Zend_Form
{
    public function init ()
    {
    	parent::init();
    	
    	/* Form Elements & Other Definitions Here ... */
    	switch(APPLICATION_ENV) {
    		case 'production' :
    		    $dir = 'public_html';
    		    break;
    		case 'development' :
    		    $dir = 'public';
    		    break;
    	}
    	
//     	$formContainer = new Zend_Dojo_Form_SubForm('mainForm');
    	
//     	//Start Main Form

    	$this->setAttrib('name', 'register');
    	$this->setAttrib('method', 'post');
    	//$this->setAction('/user/register');
    	
        // create text input for name
        $userName = new Zend_Form_Element_Text('userName');
        $userName->setLabel('Username (used for login):')
            ->setOptions(array('size' => '30'))
            //->setRequired(true)
            ->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
            
        $firstName = new Zend_Form_Element_Text('firstName');
        $firstName->setLabel('First Name:')
            ->setOptions(array('size' => '30'))
            //->setRequired(true)
            ->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
            
        $lastName = new Zend_Form_Element_Text('lastName');
        $lastName->setLabel('Last Name:')
            ->setOptions(array('size' => '30'))
            //->setRequired(true)
            ->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        // create text input for email address
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email Address:');
        $email->setOptions(array('size' => '30'))
            //->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', array('allow' => Zend_Validate_Hostname::ALLOW_DNS,'mx' => true))
            ->addFilter('HtmlEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');
        
        $passWord = $this->createElement('Password', 'passWord');
        $passWord->setLabel('Password:');
        $passWord->setRequired(true);
        $passWord->addValidator(new Zend_Validate_StringLength(6, 12));
        $passWord->setAttrib('class', 'txt');
        
        $confirmPassword = $this->createElement('passWord', 'confirm_password');
        $confirmPassword->setLabel('Confirm Password:');
        $confirmPassword->setRequired(true);
        $confirmPassword->addValidator(new Zend_Validate_StringLength(6, 12));
        $confirmPassword->addValidator(new Zend_Validate_Identical(Zend_Controller_Front::getInstance()->getRequest()->getParam('passWord')));
            
        
        $captcha = new Zend_Form_Element_Captcha('captcha', array(
				'captcha' => array(
						'captcha' => 'Image',
						'wordLen' => 6,
						'timeout' => 300,
						'width' => 300,
						'height' => 100,
						'imgUrl' => '/modules/captcha/archive',
						'imgDir' => APPLICATION_PATH . '/../'.$dir.'/modules/captcha/archive',
						'font' => APPLICATION_PATH .
						'/../'.$dir.'/modules/captcha/fonts/LiberationSansRegular.ttf',
				)
		));

		$captcha->setLabel('Verification code:');
            
        // create submit button
        $submit = new Zend_Form_Element_Submit('save', array('ignore' => true));
        $submit->setLabel('Submit');
        //$submit->setLabel('Register')->setOptions(array('class' => 'submit uniqueButtonClass'));
        // attach elements to form
           $this->addElement($userName)
                ->addElement($firstName)
                ->addElement($lastName)
                ->addElement($email)
                ->addElement($passWord)
                ->addElement($confirmPassword);
           
           switch(Zend_Registry::get('enableCaptcha')) {
               case true :
                   $this->addElement($captcha);
                   break;
               case false :
           
                   break;
           }
           
           $this->addElement($submit);
    }
}