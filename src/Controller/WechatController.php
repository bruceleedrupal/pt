<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use EasyWeChat\OpenPlatform\Server\Guard;
use Symfony\Component\HttpFoundation\Request;
use EasyWeChat\Factory;
use Pimple\Container;


use EasyWeChat\OpenPlatform\Authorizer\Auth\AccessToken;


/**
 * @Route("/wechat")
 */

class WechatController extends AbstractController
{


    private  $openPlatform;

    private  $config = [
           'app_id'   => 'wxfb80869ddd644db3',
           'secret'   => 'b4805d647925124bb1edba086df7f984',
           'token'    => 's7jfCyCyj1Q2J7505zpc52c0P25B2D0j',
           'aes_key'  => 'Cc54S58C1k40NMunZujJMs2fx6M6J2K66q6QJCK81MF'
        ];

    public function __construct() {
	$this->openPlatform= Factory::openPlatform($this->config); 
	}



    /**
     * @Route("/", name="wechat")
     */
    public function wechat()
    {

    $callbackUrl = 'https://pt.iixiao.cn/wechat/handleAuthorize';
	$url = $this->openPlatform->getPreAuthorizationUrl($callbackUrl); // 传入回调URI即可	
	$url2 = $this->openPlatform->getMobilePreAuthorizationUrl($callbackUrl); // 传入回调URI即可	

	//$authorizer = $this->openPlatform->getAuthorizer('wx0be3bba47580b889');
    
      
	  $app = $this->openPlatform->officialAccount('wx0be3bba47580b889', 'refreshtoken@@@Uwk_BGhkeiXwpkARIgkoayfTZfgCjeuBo6HuTQpxvbE');

    
	  $result = $app->template_message->getPrivateTemplates();
    
  
    
    

    

	
        return $this->render('wechat/index.html.twig', [
            'url' => $url,
            'url2'=>$url2,
            'result'=>$result,          
            
        ]);
    }


   
     /**
     * @Route("/handleAuthorize", name="handleAuthorize")
     */
    public function handleAuthorize(Request $request)
    {

        
        $authCode =$request->get('auth_code');
      
        
        $response =  $this->openPlatform->handleAuthorize();

     //   $response ='';
       
        return $this->render('wechat/handleAuthorize.html.twig', [
            'param'=>$response,
            'authCode'=>$authCode
        ]);
    }



    /**
     * @Route("/event", name="wechat_event")
     */
    public function event()
    {
      
     $server = $this->openPlatform->server;


     $server->push(function ($message) {
      }, Guard::EVENT_AUTHORIZED);

     $server->push(function ($message) {
     }, Guard::EVENT_UPDATE_AUTHORIZED);

     $server->push(function ($message) {
     }, Guard::EVENT_UNAUTHORIZED);

     return $server->serve();

    }

}
