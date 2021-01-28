<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Controller;

use App\Application\Command\Task\CreateTask\CreateTaskCommand;
use App\Application\Command\Task\DeleteTask\DeleteTaskCommand;
use App\Application\Command\Task\EditTask\EditTaskCommand;
use App\Application\Query\Task\GetTask\GetTaskByIdQuery;
use App\Application\Query\Task\GetTaskList\GetTaskListQuery;
use App\Infrastructure\Task\Query\Doctrine\View\TaskListView;
use App\Presentation\Http\Rest\Request\CreateTaskRequest;
use App\Presentation\Http\Rest\Request\EditTaskRequest;
use App\Presentation\Http\Rest\Request\GetTaskListRequest;
use League\Tactician\CommandBus;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/task")
 * @OA\Tag(name="Task")
 */
class TaskController extends AbstractController
{
    private CommandBus $commandBus;

    private SerializerInterface $serializer;

    public function __construct(CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    public function listAction(GetTaskListRequest $request): Response
    {
        $query = new GetTaskListQuery(
            $request->getFilter(),
            $request->getPage(),
            $request->getPageSize()
        );

        /** @var TaskListView $result */
        $result = $this->commandBus->handle($query);

        return new Response(
            $this->serializer->serialize(['data' => $result, 'meta' => $result->getMeta()], 'json')
        );
    }

    /**
     * @Route(
     *     "/",
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
     * ),
     */
    public function addAction(CreateTaskRequest $request): JsonResponse
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
        ]);
    }

    /**
     * @Route(
     *     "/{id}",
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
    public function editAction(string $id, EditTaskRequest $request): JsonResponse
    {
        $command = new EditTaskCommand(
            $id,
            $request->getLabel(),
            $request->getDescription(),
            $request->getPriority(),
            $request->getDueDate()
        );

        $this->commandBus->handle($command);

        return new JsonResponse([
            'id' => $command->getId(),
        ]);
    }

    /**
     * @Route(
     *     "/{id}",
     *     name="get_task",
     *     methods={"GET"}
     * )
     * @OA\Parameter(name="id",
     *    in="path",
     *    required=true,
     *    @OA\Schema(type="string", format="uuid")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Success"
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not found"
     * )
     */
    public function getAction(string $id): Response
    {
        $result = $this->commandBus->handle(new GetTaskByIdQuery($id));

        return new Response($this->serializer->serialize($result, 'json'));
    }

    public function deleteAction(string $uuid): JsonResponse
    {
        $this->commandBus->handle(new DeleteTaskCommand($uuid));

        return new JsonResponse([
            'status' => 'success',
        ]);
    }
}
