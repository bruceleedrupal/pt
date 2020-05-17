<?php 
namespace App\Service;
use App\Entity\WechatOfficial;
use App\Repository\WechatOfficialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use EasyWeChat\Factory;

class WechatOfficeService {
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    
    /**    
     * @var Security
     */
    protected $security;
    
    private $openPlatform;
    
    /**
     * @var WechatOfficialRepository
     */
    private $wechatOfficialRepository;
    
    
    public function __construct(EntityManagerInterface $entityManager,Security $security,WechatOfficialRepository $wechatOfficialRepository)
    {
        
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->wechatOfficialRepository = $wechatOfficialRepository;   
        
        $config = [
            'app_id'   => $_ENV['WECHAT_APP_ID'],
            'secret'   => $_ENV['WECHAT_SECRET'],
            'token'    => $_ENV['WECHAT_TOKEN'],
            'aes_key'  => $_ENV['WECHAT_AES_KEY'],
        ];        
      $this->openPlatform= Factory::openPlatform($config);      
    }
    
    public function getOfficialAccount($appId,$refreshToken){        
        $app = $this->openPlatform->officialAccount($appId,$refreshToken);         
        try {
            $result = $app->base->getValidIps();
            if(isset($result['errcode']) && $result['errcode']==61007) {
                $this->_removeUnAuthorized($appId);
            }
        }
        catch(\Exception $e) {            
            $errorResponse = $e->formattedResponse;
            if($errorResponse['errcode']==61023) {//refreshToken过期
                $authorizer =$this->openPlatform->getAuthorizer($appId);
                $authorizer_refresh_token = $authorizer['authorization_info']['authorizer_refresh_token'];
                $app = $this->openPlatform->officialAccount($appId,$authorizer_refresh_token);
                //更新refreshToken
                $wechatOfficial = $this->wechatOfficialRepository->findOneByAppId($appId);
                $wechatOfficial->setRefreshToken($authorizer_refresh_token);
                $this->entityManager->flush();
                
                return $app;
            } elseif($errorResponse['errcode']==61003) { //component is not authorized by this account hint
                $this->_removeUnAuthorized($appId);
                return NULL;
            } else {
                return NULL;
            }
        }
        return $app;
    }
   
    public function authorize($appId) {
        $user = $this->security->getUser();
        if($user->getWechatOfficial() && ($user->getWechatOfficial()->getAppId() == $appId) ){
            return FALSE;
        }
        
        $authorizer = $this->openPlatform->getAuthorizer($appId);
        $headImg = $authorizer['authorizer_info']['head_img'];
        $qrCode = $authorizer['authorizer_info']['qrcode_url'];
        $nickName = $authorizer['authorizer_info']['nick_name'];
        $refresh_token =  $authorizer['authorization_info']['authorizer_refresh_token']; 
        
        if(!$user->getWechatOfficial()) {           
            $wechatOfficial = new WechatOfficial($appId,$refresh_token);
            $wechatOfficial->setHeadImg($headImg);
            $wechatOfficial->setNickName($nickName);
            $wechatOfficial->setQrCode($qrCode);            
            $user->setWechatOfficial($wechatOfficial);   
        }
        else if ($user->getWechatOfficial()->getAppId()!= $appId){
            $wechatOfficial = $user->getWechatOfficial();
            $wechatOfficial->setAppId($appId);
            $wechatOfficial->setRefreshToken($refresh_token);
            $wechatOfficial->setHeadImg($headImg);
            $wechatOfficial->setNickName($nickName);
            $wechatOfficial->setQrCode($qrCode);
        }
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return TRUE;
    }   
    
    
    public function unAuthorize($appId){
        $wechatOfficial = $this->wechatOfficialRepository->findOneByAppId($appId);
        if($wechatOfficial) {
            $user = $wechatOfficial->getUser();
            $user->setWechatOfficial(NULL);
            $this->entityManager->persist($user);
            $this->entityManager->remove($wechatOfficial);
            $this->entityManager->flush();
            return TRUE;
        }
        return FALSE;
    }
    
    
    private function _removeUnAuthorized($appId){
        $wechatOfficial = $this->wechatOfficialRepository->findOneByAppId($appId);
        if($wechatOfficial) {
            $user = $wechatOfficial->getUser();
            $user->setWechatOfficial(NULL);
            $this->entityManager->persist($user);
            $this->entityManager->remove($wechatOfficial);
            $this->entityManager->flush();
            return TRUE;
        }
        else return FALSE;
    }
}