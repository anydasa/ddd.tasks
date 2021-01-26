<?php

declare(strict_types=1);

namespace App\Presentation\Cli\Command;

use App\Application\Command\Task\CreateTask\CreateTaskCommand as AppCreateTaskCommand;
use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Exception;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
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

        $label = $io->ask('Enter Label:', 'Some Label', function ($value) {
            $errors = $this->validator->validatePropertyValue(AppCreateTaskCommand::class, 'label', $value);
            if (count($errors) > 0) {
                throw new \RuntimeException($errors->get(0)->getMessage());
            }
            return $value;
        });

        $description = $io->ask('Enter Description:', 'Some Description', function ($value) {
            $errors = $this->validator->validatePropertyValue(AppCreateTaskCommand::class, 'description', $value);
            if (count($errors) > 0) {
                throw new \RuntimeException($errors->get(0)->getMessage());
            }
            return $value;
        });

        $priority = $io->choice('Choice Priority:', PriorityTypes::VALUE_CODE_MAP, array_key_first(PriorityTypes::VALUE_CODE_MAP));

        $dueDate = $io->ask('Enter due date:', date('Y-m-d'), function ($value) {
            $errors = $this->validator->validatePropertyValue(AppCreateTaskCommand::class, 'dueDate', $value);
            if (count($errors) > 0) {
                throw new \RuntimeException($errors->get(0)->getMessage());
            }
            return $value;
        });

        $command = new AppCreateTaskCommand(
            Uuid::uuid4()->__toString(),
            $label,
            $description,
            $priority,
            $dueDate
        );

        $this->commandBus->handle($command);

        return Command::SUCCESS;
    }
}
