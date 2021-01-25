<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GetFormCollectionRequest.
 */
class GetTaskListRequest implements RequestInterface
{
    /**
     * @Assert\Collection(
     *     fields = {
     *         "label" = @Assert\Type("string")
     *     },
     *     allowMissingFields = true,
     *     allowExtraFields = false
     * )
     *
     * @var array
     */
    private $filter;

    /**
     * @Assert\Type("integer")
     *
     * @var int
     */
    private $page;

    /**
     * @Assert\Type("integer")
     *
     * @var int
     */
    private $pageSize;

    /**
     * GetFormCollectionRequest constructor.
     */
    public function __construct(Request $request)
    {
        $this->filter = $request->get('filter', []);
        $this->page = (int) $request->get('page', 1);
        $this->pageSize = (int) $request->get('pageSize', 10);
    }

    public function getFilter(): array
    {
        return $this->filter;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
