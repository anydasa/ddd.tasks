<?php

declare(strict_types=1);

namespace App\Application\Command\Task\EditTask;

use App\Application\CommandHandlerInterface;
use App\Domain\Common\ValueObject\Label;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\Service\SurveyChecker;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\TaskId;
use Doctrine\ORM\EntityManagerInterface;

class EditTaskHandler implements CommandHandlerInterface
{
    private TaskRepositoryInterface $formRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TaskRepositoryInterface $formRepository, EntityManagerInterface $entityManager)
    {
        $this->formRepository = $formRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(EditTaskCommand $command)
    {
        $form = $this->formRepository->getById(new TaskId($command->getId()));

        $form->changeFormDetails(
            new Label($command->getLabel()),
            new Description($command->getDescription())
        );

        $this->entityManager->flush();
    }
}
