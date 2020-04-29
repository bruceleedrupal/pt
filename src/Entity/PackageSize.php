<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageSizeRepository")
 */
class PackageSize
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
     * @ORM\Column(type="decimal", precision=3, scale=1)
     *  * @Assert\Range(
     *      min = 0.1,
     *      max =  100,
     *      minMessage = "You must be at least {{ limit }}   to enter",
     *      maxMessage = "You cannot be greater than {{ limit }} to enter",
     *      notInRangeMessage = "Package price should be between {{ min }} and {{ max }}",
     * )
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="packageSizes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}
