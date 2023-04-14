<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo;

use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateDefinition;
use Shopware\Core\System\Country\CountryDefinition;
use SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation\SwagDemoTranslationDefinition;

class SwagDemoDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_demo';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return SwagDemoEntity::class;
    }

    public function getCollectionClass(): string
    {
        return SwagDemoCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([

            //Fields to be Entered in Swag_demo table in Database
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new BoolField('active', 'active')),
            (new TranslatedField('name'))->addFlags(new Required()),
            (new TranslatedField('city'))->addFlags(new Required()),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware(), new Inherited()),
            (new StringField('not_translated_field', 'notTranslatedField'))->addFlags(new ApiAware()),

            //Foreign Key Fields
            (new FkField('country_id', 'countryId', CountryDefinition::class)),
            (new FkField('countrystate_id', 'countrystateId', CountryStateDefinition::class)),
            (new FkField('media_id', 'mediaId', MediaDefinition::class)),
            (new FkField('product_id', 'productId', ProductDefinition::class, 'id')),

            //Data Association Fields
            new ManyToOneAssociationField('country', 'country_id', CountryDefinition::class, 'id'),
            new ManyToOneAssociationField('countryState', 'countrystate_id', CountryStateDefinition::class, 'id'),
            new OneToOneAssociationField('media', 'media_id', 'id', MediaDefinition::class, false),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id'),

            //TranslationsAssociationField
            (new TranslationsAssociationField(
                SwagDemoTranslationDefinition::class, 'swag_demo_id'))->addFlags(new ApiAware(), new Required()),
        ]);
    }
}
