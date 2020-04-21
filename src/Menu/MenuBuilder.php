<?php 
namespace App\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder 
{
    protected $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;        
    }

    public function adminMenu($options){        
        $menu = $this->factory->createItem('root',[
            'childrenAttributes'=>[
                'class'=>'nav nav-pills nav-sidebar flex-column',
                'data-widget'=>'treeview',
            ],            
        ]);
        
        $menu->addChild('user',[
            'uri'=>'#',
            'label' =>'<i class="nav-icon fa fa-tachometer-alt"></i>用户管理<i class="right fa fa-angle-left"></i>',
            'extras' => array('safe_label' => true),
            'childrenAttributes'=>[
                'class'=>'nav nav-treeview',               
            ],
            'attributes'=>[
                'class'=>'nav-item has-treeview',
            ],
            'linkAttributes'=>['class'=>'nav-link'],
        ]);

        $menu['user']->addChild('admin', [
            'route' => 'admin' ,
            'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>修改密码",
            'linkAttributes'=>['class'=>'nav-link'],
            'attributes'=>[
                'class'=>'nav-item',
            ],
            'extras' => array('safe_label' => true),
        ]);
        
        
        return $menu;
        
    }
    
        
}
