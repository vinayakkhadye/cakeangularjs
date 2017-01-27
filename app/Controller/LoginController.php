<?php
class LoginController extends AppController
{
    public $components  = array('Login');
    public $db          = NULL;
    /* For temporary use this may change */
    public $uses        = array('User'); 
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        
//        $this->Auth->allow();
//        ini_set('memory_limit', '-1');
//        set_time_limit(0);
//        header('Content-Type: text/html; charset=UTF-8');
        $this->autoRender   = false;   
    }

    public function index($user_id,$password)
    {
        #$user_id    = $this->request->query['user_id'];
        #$password   = $this->request->query['password'];
        
        $userExists = $this->Login->getUser($user_id,$password);
        return json_encode($userExists);
    }
}