<?php
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class OrderComponent extends Component 
{
    public $components  = array();
    public $db          = NULL;
    
    function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);
        $this->orderModel   = ClassRegistry::init('Order');
        $this->db           = $this->orderModel->getDataSource();
    }
    
    public function getOrders() 
    {
        $sql    = "select o.id, o.order_date,o.order_time,o.deliver_date,o.order_price,o.order_quantity, p.name as product_name,c.name as customer_name "
                . "from orders o "
                . "inner join products p on o.product_id=p.id "
                . "inner join customers c on o.customer_id=c.id";
        
        $rsv2   = $this->orderModel->query($sql);
        return $rsv2;
    }
    
    public function updateOrder($set,$condition)
    {
        $rs = FALSE;
        if(is_array($condition) && sizeof($condition)>0 && is_array($set) && sizeof($set)>0)
        {
            foreach($set as $key => $val)
            {
                $set[$key]  = $this->db->value($val, 'string');   
            }
            $rs = $this->orderModel->updateAll($set, $condition);
        }
        return $rs;
    }
    
    public function getMonthlyOrders($month)
    {
        switch($month)
        {
            case 'previous':
                $firstMonthCondition    = "- INTERVAL 1 MONTH";
                $secondMonthCondition   = "";
                break;
            case 'current':
                $firstMonthCondition    = "";
                $secondMonthCondition   = "+ INTERVAL 1 MONTH";
                break;
            case 'next':
                $firstMonthCondition    = "+ INTERVAL 1 MONTH";
                $secondMonthCondition   = "+ INTERVAL 2 MONTH";
                break;
            default:
                $firstMonthCondition    = "- INTERVAL 1 MONTH";
                $secondMonthCondition   = "";
        }
        
        $sql    = "select order_date,count(1) as 'total_orders' "
                . "from orders "
                . "where order_date BETWEEN DATE_FORMAT(NOW() ".$firstMonthCondition.", '%Y-%m-01') AND DATE_FORMAT(NOW() ".$secondMonthCondition." ,'%Y-%m-01') "
                . "group by order_date";
        
        $rs     = $this->orderModel->query($sql);
        return $rs;
    }

    public function getMonthlyProductSale($month)
    {
        switch($month)
        {
            case 'previous':
                $firstMonthCondition    = "- INTERVAL 1 MONTH";
                $secondMonthCondition   = "";
                break;
            case 'current':
                $firstMonthCondition    = "";
                $secondMonthCondition   = "+ INTERVAL 1 MONTH";
                break;
            case 'next':
                $firstMonthCondition    = "+ INTERVAL 1 MONTH";
                $secondMonthCondition   = "+ INTERVAL 2 MONTH";
                break;
            default:
                $firstMonthCondition    = "- INTERVAL 1 MONTH";
                $secondMonthCondition   = "";
        }
        $sql    = "select p.name,sum(o.order_quantity) as 'total_product_sale' "
                . "from orders o "
                . "inner join products p on  o.product_id=p.id "
                . "where order_date BETWEEN DATE_FORMAT(NOW() ".$firstMonthCondition.", '%Y-%m-01') AND DATE_FORMAT(NOW() ".$secondMonthCondition." ,'%Y-%m-01') "
                . "group by o.product_id";
        
        $rs     = $this->orderModel->query($sql);
        return $rs;
    }
        
    public function getLastQuery()
    {
       $log    = $this->db->getLog(false, false);        
       $size   = sizeof($log['log']);
       return $log['log'][$size-1]['query'];
   }
    
}
