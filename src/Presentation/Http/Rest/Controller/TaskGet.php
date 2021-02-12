<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Controller;

use App\Application\Query\Task\GetTask\GetTaskByIdQuery;
use League\Tactician\CommandBus;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @OA\Tag(name="Task")
 *
 * @Route(
 *     "/task/{id}",
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

    private NormalizerInterface $serializer;

    public function __construct(CommandBus $commandBus, NormalizerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): JsonResponse
    {
        $result = $this->commandBus->handle(new GetTaskByIdQuery($id));

        return new JsonResponse($this->serializer->normalize($result, 'array'));
    }
}
