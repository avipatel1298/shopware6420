<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(FirstPluginEntity $entity)
 * @method void                set(string $key, FirstPluginEntity $entity)
 * @method FirstPluginEntity[]    getIterator()
 * @method FirstPluginEntity[]    getElements()
 * @method FirstPluginEntity|null get(string $key)
 * @method FirstPluginEntity|null first()
 * @method FirstPluginEntity|null last()
 */
 #[Package('core')]
class FirstPluginCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return FirstPluginEntity::class;
    }
}