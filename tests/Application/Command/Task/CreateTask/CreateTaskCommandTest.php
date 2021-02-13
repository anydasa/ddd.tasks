<?php

namespace Test\Application\Command\Task\CreateTask;

use App\Application\Command\Task\CreateTask\CreateTaskCommand;
use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateTaskCommandTest extends KernelTestCase
{
    private CommandBus $commandBus;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->commandBus = $kernel->getContainer()->get('tactician.commandbus.validator');
    }

    /**
     * @group integration
     * @dataProvider getValidCommandData
     */
    public function testSuccess(string $id, string $label, string $description, string $priority, string $date)
    {
        $command = new CreateTaskCommand($id, $label, $description, $priority, $date);
        $result = $this->commandBus->handle($command);

        $this->assertEquals(null, $result);
    }

    /**
     * @group integration
     * @dataProvider getInvalidCommandData
     */
    public function testException(string $id, string $label, string $description, string $priority, string $date)
    {
        $this->expectException(InvalidCommandException::class);

        $command = new CreateTaskCommand($id, $label, $description, $priority, $date);
        $this->commandBus->handle($command);
    }

    public function getValidCommandData(): array
    {
        return [
            [Uuid::uuid4()->toString(), 'Label1', 'Description1', PriorityTypes::CODE_LOW, '2020-12-01'],
            [Uuid::uuid4()->toString(), 'Label2', 'Description2', PriorityTypes::CODE_MEDIUM, '2021-12-01'],
            [Uuid::uuid4()->toString(), 'Label3', 'Description3', PriorityTypes::CODE_HIGH, '2021-12-01'],
        ];
    }

    public function getInvalidCommandData(): array
    {
        return [
            [Uuid::uuid4()->toString(), 'Label', 'Description', PriorityTypes::CODE_LOW, '2020-12-0'],
            [Uuid::uuid4()->toString(), 'Label', 'Description', 'Wrong priority', '2021-12-01'],
            [Uuid::uuid4()->toString(), 'Label', '', PriorityTypes::CODE_HIGH, '2021-12-01'],
            [Uuid::uuid4()->toString(), '', 'Description', PriorityTypes::CODE_HIGH, '2021-12-01'],
            ['', 'Label', 'Description', PriorityTypes::CODE_HIGH, '2021-12-01'],
        ];
    }
}
