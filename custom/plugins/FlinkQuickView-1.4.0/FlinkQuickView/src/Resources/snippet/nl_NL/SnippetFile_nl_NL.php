<?php declare(strict_types=1);

namespace Flink\QuickView\Resources\snippet\nl_NL;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_nl_NL implements SnippetFileInterface
{

    public function getName(): string
    {

        return 'storefront.nl-NL';

    }

    public function getPath(): string
    {

        return __DIR__ . '/storefront.nl-NL.json';

    }

    public function getIso(): string
    {

        return 'nl-NL';

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
