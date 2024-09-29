<?php

namespace App\Entity;

use App\Repository\BidRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BidRepository::class)]
class Bid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'float')]
    private float $totalFees;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, cascade: ['remove'], inversedBy: 'bids')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Vehicle $vehicle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalFees(): ?float
    {
        return $this->totalFees;
    }

    public function setTotalFees(float $totalFees): self
    {
        $this->totalFees = $totalFees;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
