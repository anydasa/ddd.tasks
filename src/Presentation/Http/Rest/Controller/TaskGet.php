<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Controller;

use App\Application\Query\Task\GetTask\GetTaskByIdQuery;
use League\Tactician\CommandBus;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @OA\Tag(name="Task")
 *
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
class TaskGet
{
    private CommandBus $commandBus;

    private SerializerInterface $serializer;

    public function __construct(CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): Response
    {
        $result = $this->commandBus->handle(new GetTaskByIdQuery($id));

        return new Response($this->serializer->serialize($result, 'json'));
    }
}
