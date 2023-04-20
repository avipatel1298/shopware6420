<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\BlogDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\BlogCategoryDefinition;

class CategoryMappingDefinition extends MappingEntityDefinition
{
    public const ENTITY_NAME = 'blog_category_mapping';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('blog_category_id', 'blogCategoryId', BlogCategoryDefinition::class,'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('blog_id', 'blogId', BlogDefinition::class,'id'))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('blogCategoryId', 'blog_category', BlogCategoryDefinition::class, 'id'),
            new ManyToOneAssociationField('blogId', 'blog_id', BlogDefinition::class, 'id')
        ]);
    }
}

