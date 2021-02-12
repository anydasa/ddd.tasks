<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Controller;

use App\Application\Command\Task\CreateTask\CreateTaskCommand;
use App\Presentation\Http\Rest\Request\CreateTaskRequest;
use League\Tactician\CommandBus;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Task")
 *
 * @Route(
 *     "/task/",
 *     name="create_task",
 *     methods={"POST"}
 * )
 *
 * @OA\Response(
 *     response=201,
 *     description="Task created successfully"
 * )
 * @OA\Response(
 *     response=400,
 *     description="Bad request"
 * )
 * @OA\Response(
 *     response=409,
 *     description="Conflict"
 * )
 * @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref=@Model(type="\App\Presentation\Http\Rest\Request\CreateTaskRequest"))
 * )
 */
class TaskAdd
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(CreateTaskRequest $request): JsonResponse
    {
        $command = new CreateTaskCommand(
            $request->getId() ?? Uuid::uuid4()->__toString(),
            $request->getLabel(),
            $request->getDescription(),
            $request->getPriority(),
            $request->getDueDate()
        );

        $this->commandBus->handle($command);

        return new JsonResponse([
            'id' => $command->getId(),
        ], Response::HTTP_CREATED);
    }
}
