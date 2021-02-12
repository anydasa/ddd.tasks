<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Controller;

use App\Application\Command\Task\EditTask\EditTaskCommand;
use App\Presentation\Http\Rest\Request\EditTaskRequest;
use League\Tactician\CommandBus;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Task")
 *
 * @Route(
 *     "/task/{id}",
 *     name="edit_task",
 *     methods={"PUT"}
 * )
 * @OA\Parameter(name="id",
 *    in="path",
 *    required=true,
 *    @OA\Schema(type="string", format="uuid")
 * )
 * @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref=@Model(type="\App\Presentation\Http\Rest\Request\EditTaskRequest"))
 * )
 *
 * @OA\Response(
 *     response=204,
 *     description="Task updated successfully"
 * )
 * @OA\Response(
 *     response=400,
 *     description="Bad request"
 * )
 */
class TaskEdit
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $id, EditTaskRequest $request): JsonResponse
    {
        $command = new EditTaskCommand(
            $id,
            $request->getLabel(),
            $request->getDescription(),
            $request->getPriority(),
            $request->getDueDate()
        );

        $this->commandBus->handle($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
