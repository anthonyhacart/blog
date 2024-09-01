<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\ContentRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tag/{slug}', name: 'tag_list')]
class SearchByTagAction extends AbstractController
{
    public function __construct(private readonly ContentRepository $contentRepository)
    {
    }

    public function __invoke(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Tag $tag): Response
    {
        return $this->render('pages/tags.html.twig', ['contents' => $tag->getContents()]);
    }
}
