<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(BlogTranslationEntity $entity)
 * @method void                set(string $key, BlogTranslationEntity $entity)
 * @method BlogTranslationEntity[]    getIterator()
 * @method BlogTranslationEntity[]    getElements()
 * @method BlogTranslationEntity|null get(string $key)
 * @method BlogTranslationEntity|null first()
 * @method BlogTranslationEntity|null last()
 */
 #[Package('core')]
class BlogTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BlogTranslationEntity::class;
    }
}