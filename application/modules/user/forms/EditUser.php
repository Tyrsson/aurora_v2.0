<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class User_Form_EditUser extends Zend_Dojo_Form
{
    public function init ()
    {

        $ident = Zend_Auth::getInstance()->getIdentity();
        $this->setMethod('post');
        
        $page = new Zend_Form_Element_Hidden('page');
        
        $userid = new Zend_Form_Element_Hidden('userId');

        $roles = new User_Model_Roles();
        $role = new Zend_Dojo_Form_Element_FilteringSelect('role');
        //$role->setRequired(true);
        $role->setLabel('User Role');
        //$customRoles = array("6" => 'Bronze', "7" => 'Silver', "8" => 'Gold');
        $role->setMultiOptions($roles->fetchAllRoles());
        
               
        $username = new Zend_Dojo_Form_Element_TextBox('userName');
        $username->setLabel('User Name (Used for login):')
            ->setOptions(array('size' => '30'))
            ->setRequired(true)
            //->addValidator('Alnum')
            //->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        
        $firstname = new Zend_Dojo_Form_Element_TextBox('firstName');
        $firstname->setLabel('First Name:')
            ->setOptions(array('size' => '30'))
            //->setRequired(true)
            //->addValidator('Alnum')
            //->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        $lastname = new Zend_Dojo_Form_Element_TextBox('lastName');
        $lastname->setLabel('Last Name:')
            ->setOptions(array('size' => '30'))
            //->setRequired(true)
            //->addValidator('Alnum')
            //->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
        
        $company = new Zend_Dojo_Form_Element_TextBox('companyName');
        $company->setLabel('Company Name:')
        ->setOptions(array('size' => '100'))
        ->setRequired(true)
        //->addValidator('Alnum')
        //->addFilter('HtmlEntities')
        ->addFilter('StringTrim');
        
        $companyUri = new Zend_Dojo_Form_Element_TextBox('companyUri');
        $companyUri->setLabel('Company Uri:')
        ->setOptions(array('size' => '100'))
        ->setRequired(true)
        //->addValidator('Alnum')
        //->addFilter('HtmlEntities')
        ->addFilter('StringTrim');

        $email = new Zend_Dojo_Form_Element_TextBox('email');
        $email->setLabel('Email Address:');
        $email->setOptions(array('size' => '50'))
            //->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            //->addFilter('HTMLEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');
            
        $city = new Zend_Dojo_Form_Element_TextBox('addrCity');
        $city->setLabel('City:')
            ->setOptions(array('size' => '20'))
            //->setRequired(true)
            ->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
            
        $zipcode = new Zend_Dojo_Form_Element_TextBox('addrZip');
        $zipcode->setLabel('Zip Code:')
            ->setOptions(array('size' => '10'))
            //->setRequired(true)
            //->addValidator('Alnum')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');
            
        $state = new Zend_Dojo_Form_Element_FilteringSelect('addrState');
        $state->setLabel('State:')->setMultiOptions(
        array('1' => 'Alabama', '2' => 'Alaska', '3' => 'Arizona'));
        
        $status = new Zend_Dojo_Form_Element_FilteringSelect('uStatus');
        $status->setLabel('Status:')->setMultiOptions(array('disabled' => 'Disabled', 'enabled' => 'Enabled'));
        
        $shipAddOne = new Zend_Dojo_Form_Element_TextBox('addrStreetOne');
        $shipAddOne->setLabel('Address 1:');
        $shipAddOne->setOptions(array('size' => '100'))
            	   //->setRequired(true)
            	   ->addValidator('NotEmpty', true)
                   ->addFilter('HtmlEntities')
                   ->addFilter('StringTrim');
                   
        $shipAddTwo = new Zend_Dojo_Form_Element_TextBox('addrStreetTwo');
        $shipAddTwo->setLabel('Address 2:');
        $shipAddTwo->setOptions(array('size' => '100'))
            	   //->setRequired(true)
            	   //->addValidator('NotEmpty', true)
                   ->addFilter('HtmlEntities')
                   ->addFilter('StringTrim');
        /*$password = $this->createElement('password', 'password');
        $password->setLabel('Password:');
        $password->setRequired(true);
        $password->addValidator(new Zend_Validate_StringLength(6, 12));
        $password->setAttrib('class', 'txt');
        $confirmPassword = $this->createElement('password', 'confirm_password');
        $confirmPassword->setLabel('Confirm Password:');
        $confirmPassword->setRequired(true);
        $confirmPassword->addValidator(new Zend_Validate_StringLength(6, 12));
        $confirmPassword->addValidator(
        new Zend_Validate_Identical(
        Zend_Controller_Front::getInstance()->getRequest()
            ->getParam('password')));*/
        // create submit button
        $submit = new Zend_Dojo_Form_Element_SubmitButton('save');
        $submit->setLabel('Submit')->setOptions(array('class' => 'submit'));
        // attach elements to form
        //$this->addElement($groupid)
        $this->addElement($userid)
             ->addElement($page)
             ->addElement($role)
             ->addElement($company)
             ->addElement($companyUri)
            // ->addElement($hiddengroupid)
             ->addElement($status)
             ->addElement($username)
            ->addElement($firstname)
            ->addElement($lastname)
            ->addElement($email)
            ->addElement($shipAddOne)
            ->addElement($shipAddTwo)
            ->addElement($city)
            ->addElement($state)
            ->addElement($zipcode)
            //->addElement($password)
            //->addElement($confirmPassword)
            ->addElement($submit);  
    }
//     public function loadDefaultDecorators()
//     {
//         $this->setDecorators(array(
//             'FormElements',
//             'Fieldset',
//             'Form'
//         ));
//     }
}