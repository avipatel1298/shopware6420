<?php declare(strict_types=1);

namespace Flink\QuickView\Resources\snippet\ru_RU;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_ru_RU implements SnippetFileInterface
{

    public function getName(): string
    {

        return 'storefront.ru-RU';

    }

    public function getPath(): string
    {

        return __DIR__ . '/storefront.ru-RU.json';

    }

    public function getIso(): string
    {

        return 'ru-RU';

    }

    public function getAuthor(): string
    {

        return 'FlinkFactory';

    }

    public function isBase(): bool
    {

        return false;

    }

}
