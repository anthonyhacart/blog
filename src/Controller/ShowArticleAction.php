<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article/{slug}', name: 'article_show')]
class ShowArticleAction extends AbstractController
{
    public function __invoke(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Article $article): Response
    {
        return $this->render('pages/content/article/show.html.twig', ['article' => $article]);
    }
}
