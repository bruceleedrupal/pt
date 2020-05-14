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

    private $mobileDetect;
    
    public function __construct() {
    	$this->openPlatform= Factory::openPlatform($this->config); 
    	$this->mobileDetect = new \Mobile_Detect;
	}


	public function authUrlBlock(){
	    $callbackUrl = 'https://pt.iixiao.cn/wechat/handleAuthorize';
	    
	    $isMobile = $this->mobileDetect->isMobile();
	    if($isMobile)
	        $authUrl = $this->openPlatform->getMobilePreAuthorizationUrl($callbackUrl); // 传入回调URI即可
	    else 
	        $authUrl = $this->openPlatform->getPreAuthorizationUrl($callbackUrl); // 传入回调URI即可	
        return $this->render('wechat/authUrlBlock.html.twig', [
            'authUrl' => $authUrl            
        ]);
	        
	          
	}
	
	
    /**
     * @Route("/", name="wechat")
     */
    public function wechat()
    {

        $callbackUrl = 'https://pt.iixiao.cn/wechat/handleAuthorize';
    	$url = $this->openPlatform->getPreAuthorizationUrl($callbackUrl); // 传入回调URI即可	
    	$url2 = $this->openPlatform->getMobilePreAuthorizationUrl($callbackUrl); // 传入回调URI即可	

    // $result=     $authorizer = $this->openPlatform->getAuthorizer('wx0be3bba47580b889');
    
      
       //2020.05.08 16.04
    //  $app = $this->openPlatform->officialAccount('wx0be3bba47580b889', 'refreshtoken@@@riwDd3Bl-dFJE9_a8sWT44oyVoP0jXdE1x4bmeSSujc');
  
    
     
	 
	  
	//  $result = $app->user->list();
	  /*
	 $result =  $app->template_message->send([
        'touser' => 'oqYJP1c4pGo2Nl9dpTrZ0hZmfcoE',
        'template_id' => 'vEKbY7jV9U5D0uyQ6Sifm5zzatqbN8H_uVZ3Ddn0gmk',
        'data' => [
            'first' => 'VALUE',
            'keyword1' => 'VALUE1',
            'keyword2' => '<a href="tel:18116381898">18116381898</a>',
            'keyword3' => 'VALUE3',
            'remark' => 'VALUE3',
        ],
    ]);
    
  
    */
    

    

	
        return $this->render('wechat/index.html.twig', [
            'url' => $url,
            'url2'=>$url2,
         //   'result'=>$result,          
	    //'authorizer'=>$authorizer,
            
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
