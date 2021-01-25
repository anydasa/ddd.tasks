<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EditFormRequest.
 */
class EditTaskRequest implements RequestInterface
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * UpdateFormRequest constructor.
     */
    public function __construct(Request $request)
    {
        $data = json_decode((string) $request->getContent(), true);

        $this->id = $request->get('uuid');
        $this->label = $data['label'] ?? '';
        $this->description = $data['description'] ?? '';
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
