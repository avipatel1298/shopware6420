<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlogCategory;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\CategoryMappingDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\BlogDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation\BlogCategoryTranslationDefinition;

class BlogCategoryDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'blog_category';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return BlogCategoryEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BlogCategoryCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([

            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new TranslatedField('categoryName',))->AddFlags(new Required()),

            new ManyToManyAssociationField('blog-text', BlogDefinition::class,
                CategoryMappingDefinition::class,
                'blog_category_id', 'blog_id',
                'id',
                'id'),

            (new TranslationsAssociationField(
                BlogCategoryTranslationDefinition::class,
                'blog_category_id'))->addFlags(new ApiAware()),
        ]);
    }
}
