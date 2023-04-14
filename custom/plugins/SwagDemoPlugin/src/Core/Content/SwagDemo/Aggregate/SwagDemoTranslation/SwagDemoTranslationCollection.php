<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(SwagDemoTranslationEntity $entity)
 * @method void                set(string $key, SwagDemoTranslationEntity $entity)
 * @method SwagDemoTranslationEntity[]    getIterator()
 * @method SwagDemoTranslationEntity[]    getElements()
 * @method SwagDemoTranslationEntity|null get(string $key)
 * @method SwagDemoTranslationEntity|null first()
 * @method SwagDemoTranslationEntity|null last()
 */
 #[Package('core')]
class SwagDemoTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SwagDemoTranslationEntity::class;
    }
}