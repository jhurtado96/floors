<?php

declare(strict_types=1);

namespace App\Domain\Building;

class Building
{
    private $elevators;
    private $floors;

    public function __construct(int $floors, array $elevators)
    {
        $this->floors = $floors;
        $this->elevators = $elevators;
    }

    public function getFloors(): int
    {
        return $this->floors;
    }

    public function getElevators(): array
    {
        return $this->elevators;
    }
}
