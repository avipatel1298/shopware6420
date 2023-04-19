<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlogCategory;


use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\SwagBlogDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation\SwagBlogCategoryTranslationDefinition;

class SwagBlogCategoryDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_blog_category';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

//    public function getEntityClass(): string
////    {
////        return SwagBlogCategoryEntity::class;
////    }
////
////    public function getCollectionClass(): string
////    {
////        return SwagBlogCategoryCollection::class;
////    }
///
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([

            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new TranslatedField('category_name',))->AddFlags(new Required()),

            new OneToManyAssociationField('categoryIds',
                SwagBlogDefinition::class,
                'category_id',
                'id'),


            (new TranslationsAssociationField(
                SwagBlogCategoryTranslationDefinition::class,
                'swag_blog_category_id'))->addFlags(new ApiAware()),
        ]);
    }
}
