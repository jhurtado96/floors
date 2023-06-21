<?php

namespace App\Service;

use App\Domain\Building\Building;
use App\Domain\Elevator\Elevator;

class ElevatorManager
{
    private Building $building;

    public function __construct(Building $building)
    {
        $this->building = $building;
    }
    public function getBuilding(): Building
    {
        return $this->building;
    }
    public function callElevator(int $requestedFloor): Elevator
    {
        $elevators = $this->building->getElevators();

        $nearestElevator = $elevators[0];
        $smallestDifference = abs($elevators[0]->getCurrentFloor() - $requestedFloor);

        foreach ($elevators as $elevator) {
            $difference = abs($elevator->getCurrentFloor() - $requestedFloor);
            if ($difference < $smallestDifference) {
                $nearestElevator = $elevator;
                $smallestDifference = $difference;
            }
        }

        $nearestElevator->setCurrentFloor($requestedFloor);

        return $nearestElevator;
    }
}
