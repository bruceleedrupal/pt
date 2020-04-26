<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\School;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SchoolSessionStorage 
{
    const SCHOOL_KEY_NAME = 'schoolId';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    public function set(?int $schoolId): void
    {
        $this->session->set(self::SCHOOL_KEY_NAME, $schoolId);
    }

    public function remove(): void
    {
        $this->session->remove(self::SCHOOL_KEY_NAME);
    }

    public function getSchoolById(): ?School
    {     
       if ($this->has()) {
            return $this->entityManager->getRepository('App\Entity\School')->findOneById($this->get());
        }

        return null;
    }

    public function has(): bool
    {
        return $this->session->has(self::SCHOOL_KEY_NAME);
    }

    public function get(): ?int
    { 
       return $this->session->get(self::SCHOOL_KEY_NAME);
    }
}
