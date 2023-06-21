<?php

declare(strict_types=1);

namespace App\Infrastructure\Simulation;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\ElevatorManager;
use App\Domain\Building\Building;
use App\Domain\Elevator\Elevator;

class SimulationCommand extends Command
{
    private ElevatorManager $elevatorManager;
    private Building $building;

    protected function configure()
    {
        $this
            ->setName('app:test')
            ->setDescription('Test command');
    }

    public function __construct(ElevatorManager $elevatorManager, Building $building)
    {
        parent::__construct();
        $this->elevatorManager = $elevatorManager;
        $this->building = $building;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        try {
            $symfonyStyle->info('START SIMULATION COMMAND');

            $startTime = new \DateTime('09:00');
            $endTime = new \DateTime('20:00');
            $currentTime = clone $startTime;

            while ($currentTime <= $endTime) {
                $this->simulateSequences($currentTime, $symfonyStyle);
                $currentTime = $currentTime->add(new \DateInterval('PT1M'));
            }
        } catch (\Throwable $exception) {
            $symfonyStyle->error(sprintf('ERROR SIMULATION COMMAND: %s', $exception->getMessage()));
            return Command::FAILURE;
        }

        $symfonyStyle->success('SUCCESS SIMULATION COMMAND');
        return Command::SUCCESS;
    }

    private function getSequences(): array
    {
        return [
            [
                'start' => new \DateTime('09:00'),
                'end' => new \DateTime('11:00'),
                'interval' => 5,
                'destinationFloor' => 2,
            ],
            [
                'start' => new \DateTime('09:00'),
                'end' => new \DateTime('10:00'),
                'interval' => 10,
                'destinationFloor' => 1,
            ],
            [
                'start' => new \DateTime('11:00'),
                'end' => new \DateTime('18:20'),
                'interval' => 20,
                'destinationFloor' => [1, 2, 3],
            ],
            [
                'start' => new \DateTime('14:00'),
                'end' => new \DateTime('15:00'),
                'interval' => 4,
                'destinationFloor' => [1, 2, 3],
            ],
        ];
    }

    private function simulateSequences(\DateTime $currentTime, SymfonyStyle $symfonyStyle): void
    {
        $sequences = $this->getSequences();

        foreach ($sequences as $sequence) {
            $startTime = $sequence['start'];
            $endTime = $sequence['end'];

            if ($currentTime >= $startTime && $currentTime <= $endTime) {
                $interval = $sequence['interval'];
                $destinationFloors = is_array($sequence['destinationFloor']) ? $sequence['destinationFloor'] : [$sequence['destinationFloor']];

                if ($currentTime->format('i') % $interval === 0) {
                    foreach ($destinationFloors as $destinationFloor) {
                        $elevator = $this->elevatorManager->callElevator($destinationFloor);
                        $currentFloor = $elevator->getCurrentFloor();
                        $traveledFloors = intval($elevator->getTraveledFloors() + abs($currentFloor - $destinationFloor));

                        $elevator->setCurrentFloor($destinationFloor);
                        $elevator->setTraveledFloors($traveledFloors);
                    }
                }
            }
        }

        $this->displayElevatorPositions($currentTime, $symfonyStyle);
    }

    private function displayElevatorPositions(\DateTime $currentTime, SymfonyStyle $symfonyStyle): void
    {
        $elevators = $this->building->getElevators();

        $symfonyStyle->writeln('Elevator Positions:');
        foreach ($elevators as $index => $elevator) {
            $currentFloor = $elevator->getCurrentFloor();
            $traveledFloors = $elevator->getTraveledFloors();
            $symfonyStyle->writeln("Elevator $index is at floor $currentFloor at {$currentTime->format('H:i')}. Total floors traveled: $traveledFloors");
        }
        $symfonyStyle->newLine();
    }
}
