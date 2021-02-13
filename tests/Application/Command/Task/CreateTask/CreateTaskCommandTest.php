<?php

namespace Test\Application\Command\Task\CreateTask;

use App\Application\Command\Task\CreateTask\CreateTaskCommand;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use League\Tactician\CommandBus;
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
     * @dataProvider \Test\Application\Command\Task\CreateTask\DataProvider::getValidCommandData
     */
    public function testSuccess(string $id, string $label, string $description, string $priority, string $date)
    {
        $command = new CreateTaskCommand($id, $label, $description, $priority, $date);
        $result = $this->commandBus->handle($command);

        $this->assertEquals(null, $result);
    }

    /**
     * @group integration
     * @dataProvider \Test\Application\Command\Task\CreateTask\DataProvider::getInvalidCommandData
     */
    public function testException(string $id, string $label, string $description, string $priority, string $date)
    {
        $this->expectException(InvalidCommandException::class);

        $command = new CreateTaskCommand($id, $label, $description, $priority, $date);
        $this->commandBus->handle($command);
    }
}
