<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'language',
                LanguageDefinition::class,
                'swag_demo_id ','id')
        );
    }

    public function getDefinitionClass(): string
    {
        return LanguageDefinition::class;
    }

}

