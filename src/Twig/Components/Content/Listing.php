<?php

declare(strict_types=1);

namespace App\Twig\Components\Content;

use App\Repository\ContentRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Listing
{
    use ComponentToolsTrait;
    use DefaultActionTrait;

    private const PER_PAGE = 6;

    #[LiveProp]
    public int $page = 1;

    public function __construct(private readonly ContentRepository $contentRepository)
    {
    }

    #[LiveAction]
    public function more(): void
    {
        ++$this->page;
    }

    public function hasMore(): bool
    {
        return \count($this->contentRepository->findBy($this->getCriteria())) > ($this->page * self::PER_PAGE);
    }

    public function getItems(): array
    {
        $page = max(0, $this->page - 1);
        $offset = $page * self::PER_PAGE;

        return $this->contentRepository->findBy(
            $this->getCriteria(),
            ['id' => 'desc'],
            self::PER_PAGE,
            $offset
        );
    }

    private function getCriteria(): array
    {
        return ['status' => 'published'];
    }
}
