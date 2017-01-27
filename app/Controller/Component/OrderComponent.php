<?php
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class OrderComponent extends Component 
{
    
    public $components              = array();
    
    function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);
    }
    
    public function getOrders() 
    {
        $orderModel  = ClassRegistry::init('Order');
        $sql    = "select o.id, o.order_date,o.order_time,o.deliver_date,o.order_price,o.order_quantity, p.name as product_name,c.name as customer_name "
                . "from orders o "
                . "inner join products p on o.product_id=p.id "
                . "inner join customers c on o.customer_id=c.id";
        
        $rsv2   = $orderModel->query($sql);
        return $rsv2;
    }
}
