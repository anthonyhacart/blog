<?php

declare(strict_types=1);

namespace App\Twig\Components\Content;

use App\Repository\LinkRepository;
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

    private const PER_PAGE = 5;

    #[LiveProp]
    public int $page = 1;

    public function __construct(private readonly LinkRepository $linkRepository)
    {
    }

    #[LiveAction]
    public function more(): void
    {
        ++$this->page;
    }

    public function hasMore(): bool
    {
        return \count($this->linkRepository->findAll()) > ($this->page * self::PER_PAGE);
    }

    public function getItems(): array
    {
        $links = $this->linkRepository->findBy([], ['updatedAt' => 'desc'], self::PER_PAGE, $this->page * self::PER_PAGE);

        return $links;
    }
}
