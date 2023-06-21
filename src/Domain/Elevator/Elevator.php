<?php

declare(strict_types=1);

namespace App\Domain\Elevator;

final class Elevator
{
    private $currentFloor = 0;
    private $traveledFloors = 0;

    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    public function setCurrentFloor(int $floor): void
    {
        $this->traveledFloors += abs($this->currentFloor - $floor);
        $this->currentFloor = $floor;
    }

    public function getTraveledFloors(): int
    {
        return $this->traveledFloors;
    }

    public function setTraveledFloors(int $floors): void
    {
        $this->traveledFloors = $floors;
    }
    public function __construct(int $initialFloor = 0, int $initialTraveledFloors = 0)
    {
        $this->currentFloor = $initialFloor;
        $this->traveledFloors = $initialTraveledFloors;
    }
}
