<?php 
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use App\Service\SchoolSessionStorage;

class MenuBuilder 
{
    protected $factory;
    private $schoolSessionStorage;

    public function __construct(FactoryInterface $factory,SchoolSessionStorage $schoolSessionStorage)
    {
        $this->factory = $factory;        
        $this->schoolSessionStorage = $schoolSessionStorage;
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
            'label' =>'<i class="nav-icon fa fa-tachometer-alt"></i>代理商管理<i class="right fa fa-angle-left"></i>',
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
            'route' => 'admin_user_index' ,
            'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>所有代理商",
            'linkAttributes'=>['class'=>'nav-link'],
            'attributes'=>[
                'class'=>'nav-item',
            ],
            'extras' => array('safe_label' => true,
            'routes' => [
                [
                    'route' => 'admin_user_edit'                    
                ]
            ]
        ),
        ]);

        $menu['user']->addChild('school', [
            'route' => 'admin_school_index' ,
            'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>所有学校(校区)",
            'linkAttributes'=>['class'=>'nav-link'],
            'attributes'=>[
                'class'=>'nav-item',
            ],
            'extras' => array(
            'safe_label' => true,
            'routes' => [
                [
                    'route' => 'admin_school_edit'                    
                ],
                
            ] 
        ),
        ]);
        
        
        return $menu;
        
    }

    public function agentMenu($options){        
        $menu = $this->factory->createItem('root',[
            'childrenAttributes'=>[
                'class'=>'nav nav-pills nav-sidebar flex-column',
                'data-widget'=>'treeview',
            ],            
        ]);
        
        $menu->addChild('school',[
            'uri'=>'#',
            'label' =>'<i class="nav-icon fa fa-tachometer-alt"></i>学校(校区)管理<i class="right fa fa-angle-left"></i>',
            'extras' => array('safe_label' => true),
            'childrenAttributes'=>[
                'class'=>'nav nav-treeview',               
            ],
            'attributes'=>[
                'class'=>'nav-item has-treeview',
            ],
            'linkAttributes'=>['class'=>'nav-link'],
        ]);

        $menu['school']->addChild('agent_school_index', [
            'route' => 'agent_school_index' ,
            'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>我的学校(校区)",
            'linkAttributes'=>['class'=>'nav-link'],
            'attributes'=>[
                'class'=>'nav-item',
            ],
            'extras' => array('safe_label' => true,
            'routes' => [
                [
                    'route' => 'agent_school_new'                    
                ],
                [
                    'route' => 'agent_school_edit'                    
                ],
            ]        
            ),
        ]);


        
            $menu['school']->addChild('agent_package_address_index', [
                'route' => 'agent_package_address_index' ,
                'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>取件点",
                'linkAttributes'=>['class'=>'nav-link'],
                'attributes'=>[
                    'class'=>'nav-item',
                ],
                'extras' => array('safe_label' => true,
                'routes' => [
                    [
                        'route' => 'agent_package_address_new'                    
                    ],
                    [
                        'route' => 'agent_package_address_edit'                    
                    ],
                ]        
                ),
            ]);


            $menu['school']->addChild('agent_receive_address_index', [
                'route' => 'agent_receive_address_index' ,
                'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>收货点",
                'linkAttributes'=>['class'=>'nav-link'],
                'attributes'=>[
                    'class'=>'nav-item',
                ],
                'extras' => array('safe_label' => true,
                'routes' => [
                    [
                        'route' => 'agent_receive_address_new'                    
                    ],
                    [
                        'route' => 'agent_receive_address_edit'                    
                    ],
                ]        
                ),
            ]);

            $menu['school']->addChild('agent_package_size_index', [
                'route' => 'agent_package_size_index' ,
                'label' => "<i class='nav-icon fa fa-circle nav-icon'></i>包裹规格",
                'linkAttributes'=>['class'=>'nav-link'],
                'attributes'=>[
                    'class'=>'nav-item',
                ],
                'extras' => array('safe_label' => true,
                'routes' => [
                    [
                        'route' => 'agent_package_size_new'                    
                    ],
                    [
                        'route' => 'agent_package_size_edit'                    
                    ],
                ]        
                ),
            ]);
       
        
        return $menu;
        
    }
    
        
}
