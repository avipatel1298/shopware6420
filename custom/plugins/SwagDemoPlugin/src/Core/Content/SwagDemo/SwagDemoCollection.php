<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(SwagDemoEntity $entity)
 * @method void                set(string $key, SwagDemoEntity $entity)
 * @method SwagDemoEntity[]    getIterator()
 * @method SwagDemoEntity[]    getElements()
 * @method SwagDemoEntity|null get(string $key)
 * @method SwagDemoEntity|null first()
 * @method SwagDemoEntity|null last()
 */
 #[Package('core')]
class SwagDemoCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SwagDemoEntity::class;
    }
}