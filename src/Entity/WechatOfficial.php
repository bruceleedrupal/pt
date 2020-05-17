<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WechatOfficialRepository")
 * @UniqueEntity(
 *  fields={"appId"}, 
 *  message="同一个公众号只能绑定一个用户."
 * )
 */


class WechatOfficial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true, length=255)
     */
    private $appId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refreshToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $headImg;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qrCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickName;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="wechatOfficial", cascade={"persist"})
     */
    private $user;
    
    public function __construct(string $appId,?string $refreshToken){
        $this->appId = $appId;
        $this->refreshToken = $refreshToken;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function getHeadImg(): ?string
    {
        return $this->headImg;
    }

    public function setHeadImg(?string $headImg): self
    {
        $this->headImg = $headImg;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(?string $qrCode): self
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(?string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newWechatOfficial = null === $user ? null : $this;
        if ($user->getWechatOfficial() !== $newWechatOfficial) {
            $user->setWechatOfficial($newWechatOfficial);
        }
        return $this;
    }

  
}
