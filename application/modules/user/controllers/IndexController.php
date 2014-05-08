<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class User_IndexController extends Zend_Controller_Action
{
    public $auth;
    
    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
    }
    public function indexAction()
    {// login action
        
    /* Get an instance of the System Logger, this is initalized in the Bootstrap file
     * stored in the registry, this insures all logging occurs through a common logger
    */
    $log = Zend_Registry::get('log');
    // Create an instance of our User Login Form
    $form = new User_Form_Login;
    // is the request a post ?
    switch($this->_request->isPost()) {
        case true :
            try {
                if ($form->isValid($this->_request->getPost()))
                {
                    // get the form values as a object of type new stdClass();
                    $post = (object)$form->getValues();
                    // Get a config'ed instance of the Zend Auth Db adapter ready for use
                    $authAdapter = $this->getAuthAdapter();
                    // pass to the adapter the submitted username and password
                    $authAdapter->setIdentity($post->username)->setCredential($post->password);
                    // Attempt a authentication, returns Zend_Auth_Result
                    $result = $this->auth->authenticate($authAdapter);
                    // check the result, returns bool
                    switch($result->isValid()) {
                        case true :
                            // If authentication was successful we should generate a new session id to prevent session fixation
                            Zend_Session::regenerateId();
                            // Get an storage instance, in our case this will be written to a session db table
                            $authStorage = $this->auth->getStorage();
                            /* We will only write the information we need in the session,
                             * You must be careful not to store sensitive data in the session !!
                            */
                            $userInfo = $authAdapter->getResultRowObject(array('userId','userName','role'));
                            // persist the identity to storage
                            $authStorage->write($userInfo);
                            // pass an instance of Zend_Auth so we can get the userId and userName
                            $log->addUserEvent(Zend_Auth::getInstance(), null, null);
                            // Use the convience method to log an informational log entry to track all users logins
                            $log->info('Successful Login');
                            // Provide a nice message to the user that they were logged in.
                            $this->_helper->getHelper('FlashMessenger')->addMessage('You were sucessfully logged in as&nbsp;' . $userInfo->userName);
                            // Redirect this user to a given location based on their role
                            switch ($userInfo->role) {
                                // We do not break here since the are both going to the same uri
                                case "admin":
                                    // forward($action, $controller = null, $module = null, array $params = null)
                                    $this->forward('index', 'admin', 'default', null);
                                    break;
                                case "jradmin":
                                case "mod":
                                case "user":
                                    $this->forward('list', 'page', 'default', null);
                                    break;
                            }
                            break;
                        case false :
                            // If the authentication attempt was not successfull, they need to know why, if we can tell them. log it as well.
                            $log->addUserEvent(null, $post->username, null);
                            $log->info('Failed login attempt');
                            $this->view->messages = $result->getMessages();
                            break;
                    }
                }
            } catch (Zend_Exception $e) {
                // System Log only needs the exception object
                $log->err($e);
            }
            break;
        case false :
        default:
    }
    // Assign the form object to the view for use
    $this->view->form = $form;
    }////////////////////////////////////////////////////////////////////
    public function registerAction()
    {
        
    }
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
        $this->_redirect('/');
    }///////////////////////////////////////////////////////////////////
    protected function getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter, 'user', 'userName', 'passWord', 'sha1(?) AND uStatus != "disabled"');
        return $authAdapter;
    }///////////////////////////////////////////////////////////////////
}
