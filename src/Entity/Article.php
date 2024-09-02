<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Article extends Content
{
    #[ORM\Column(type: 'text')]
    private string $content;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function isArticle(): bool
    {
        return true;
    }
}
