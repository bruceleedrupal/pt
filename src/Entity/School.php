<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolRepository")
 */
class School
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)     
     * @Assert\Range(
     *      min = 0.1,
     *      max = 0.5,
     *      minMessage = "You must be at least {{ limit }}   to enter",
     *      maxMessage = "You cannot be greater than {{ limit }} to enter",
     *      notInRangeMessage = "Commission should be between {{ min }} and {{ max }}",
     * )
     */
   
    private $commission;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="schools")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)
     * @Assert\Range(
     *      min = 0.1,
     *      max = 0.9,
     *      minMessage = "You must be at least {{ limit }}   to enter",
     *      maxMessage = "You cannot be greater than {{ limit }} to enter",
     *      notInRangeMessage = "Driver Commission should be between {{ min }} and {{ max }}",
     * )
     */
    private $assistantCommission;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PackageAddress", mappedBy="school")
     */
    private $packageAddresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReceiveAddress", mappedBy="school")
     */
    private $receiveAddresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PackageSize", mappedBy="school")
     */
    private $packageSizes;


    public function __construct(){
        $this->commission = 0.2;
        $this->assistantCommission = 0.3;
        $this->packageAddresses = new ArrayCollection();
        $this->receiveAddresses = new ArrayCollection();
        $this->packageSizes = new ArrayCollection();

   }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCommission(): ?string
    {
        return $this->commission;
    }

    public function setCommission(string $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAssistantCommission(): ?string
    {
        return $this->assistantCommission;
    }

    public function setAssistantCommission(string $assistantCommission): self
    {
        $this->assistantCommission = $assistantCommission;

        return $this;
    }

    /**
     * @return Collection|PackageAddress[]
     */
    public function getPackageAddresses(): Collection
    {
        return $this->packageAddresses;
    }

    public function addPackageAddress(PackageAddress $packageAddress): self
    {
        if (!$this->packageAddresses->contains($packageAddress)) {
            $this->packageAddresses[] = $packageAddress;
            $packageAddress->setSchool($this);
        }

        return $this;
    }

    public function removePackageAddress(PackageAddress $packageAddress): self
    {
        if ($this->packageAddresses->contains($packageAddress)) {
            $this->packageAddresses->removeElement($packageAddress);
            // set the owning side to null (unless already changed)
            if ($packageAddress->getSchool() === $this) {
                $packageAddress->setSchool(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReceiveAddress[]
     */
    public function getReceiveAddresses(): Collection
    {
        return $this->receiveAddresses;
    }

    public function addReceiveAddress(ReceiveAddress $receiveAddress): self
    {
        if (!$this->receiveAddresses->contains($receiveAddress)) {
            $this->receiveAddresses[] = $receiveAddress;
            $receiveAddress->setSchool($this);
        }

        return $this;
    }

    public function removeReceiveAddress(ReceiveAddress $receiveAddress): self
    {
        if ($this->receiveAddresses->contains($receiveAddress)) {
            $this->receiveAddresses->removeElement($receiveAddress);
            // set the owning side to null (unless already changed)
            if ($receiveAddress->getSchool() === $this) {
                $receiveAddress->setSchool(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PackageSize[]
     */
    public function getPackageSizes(): Collection
    {
        return $this->packageSizes;
    }

    public function addPackageSize(PackageSize $packageSize): self
    {
        if (!$this->packageSizes->contains($packageSize)) {
            $this->packageSizes[] = $packageSize;
            $packageSize->setSchool($this);
        }

        return $this;
    }

    public function removePackageSize(PackageSize $packageSize): self
    {
        if ($this->packageSizes->contains($packageSize)) {
            $this->packageSizes->removeElement($packageSize);
            // set the owning side to null (unless already changed)
            if ($packageSize->getSchool() === $this) {
                $packageSize->setSchool(null);
            }
        }

        return $this;
    }
}
