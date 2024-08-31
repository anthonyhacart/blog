<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_home')]
class HomeAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('pages/index.html.twig');
    }
}
