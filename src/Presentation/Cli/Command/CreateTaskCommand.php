<?php

declare(strict_types=1);

namespace App\Presentation\Cli\Command;

use Exception;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateTaskCommand extends Command
{
    protected static $defaultName = 'app:task:create';

    protected CommandBus $commandBus;

    private LoggerInterface $logger;

    private ValidatorInterface $validator;

    public function __construct(CommandBus $commandBus, LoggerInterface $logger, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Create new Task')
            ->setHelp(
                'This command create new task.'
            );
    }

    /**
     * Executes the current command.
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $io = new SymfonyStyle($input, $output);


        $command = new \App\Application\Command\Task\CreateTask\CreateTaskCommand(
            $this->validate($io, 'Enter uuid (or skip):', 'id'),
            $this->validate($io, 'Enter Label:', 'label'),
            $this->validate($io, 'Enter Description:', 'description'),
            (int)$this->validate($io, 'Enter Priority:', 'priority'),
            $this->validate($io, 'Enter Due Date:', 'dueDate')
        );

        $this->commandBus->handle($command);

        return Command::SUCCESS;
    }

    private function validate($io, $ask, $property)
    {
        $class = \App\Application\Command\Task\CreateTask\CreateTaskCommand::class;

        return $io->ask($ask, null, function ($value) use ($class, $property) {
//            $errors = $this->validator->validatePropertyValue($class, $property, $value);
//            if (count($errors) > 0) {
//                throw new \RuntimeException($errors->get(0)->getMessage());
//            }
            return $value;
        });
    }
}
