<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin\Aggregate\FirstPluginTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(FirstPluginTranslationEntity $entity)
 * @method void                set(string $key, FirstPluginTranslationEntity $entity)
 * @method FirstPluginTranslationEntity[]    getIterator()
 * @method FirstPluginTranslationEntity[]    getElements()
 * @method FirstPluginTranslationEntity|null get(string $key)
 * @method FirstPluginTranslationEntity|null first()
 * @method FirstPluginTranslationEntity|null last()
 */
#[Package('core')]
class FirstPluginTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return FirstPluginTranslationEntity::class;
    }
}
