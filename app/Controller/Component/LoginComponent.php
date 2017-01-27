<?php
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class LoginComponent extends Component 
{
    
    public $components              = array();
    
    function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);
    }
    
    public function getUser($user_id,$password) 
    {
        $userModel  = ClassRegistry::init('User');
        
        //Get all locales
        $userResult = $userModel->find('count', array(
            'conditions'    => array('user_id' => $user_id,'password'=>  md5($password)),
            )
        );
        return $userResult;
    }
}
