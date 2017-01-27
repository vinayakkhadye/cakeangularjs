<?php
class OrderController extends AppController
{
    public $components  = array('Order');
    public $db          = NULL;
    /* For temporary use this may change */
    public $uses        = array('Order'); 
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        
//        $this->Auth->allow();
//        ini_set('memory_limit', '-1');
//        set_time_limit(0);
//        header('Content-Type: text/html; charset=UTF-8');
        $this->autoRender   = false;   
    }

    public function index()
    {
        #$user_id    = $this->request->query['user_id'];
        #$password   = $this->request->query['password'];
        
        $Orders     = $this->Order->getOrders();
        return json_encode($Orders);
    }
}