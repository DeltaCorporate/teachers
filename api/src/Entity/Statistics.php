<?php

namespace App\Entity;

use App\Repository\StatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatisticsRepository::class)
 */
class Statistics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrDeTeachrs;
    public function __construct(){
        $this->nbrDeTeachrs = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNbrDeTeachrs(): ?int
    {
        return $this->nbrDeTeachrs;
    }


    public function setNbrDeTeachrs(int $nbrDeTeachrs): self
    {
        $this->nbrDeTeachrs = $nbrDeTeachrs;

        return $this;
    }
}
