<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagDemoPlugin\Core\Content\SwagDemo\SwagDemoEntity;
use Shopware\Core\System\Language\LanguageEntity;

class SwagDemoTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $swagDemoId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var SwagDemoEntity|null
     */
    protected $swagDemo;

    /**
     * @var LanguageEntity|null
     */
    protected $language;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getSwagDemoId(): string
    {
        return $this->swagDemoId;
    }

    public function setSwagDemoId(string $swagDemoId): void
    {
        $this->swagDemoId = $swagDemoId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getSwagDemo(): ?SwagDemoEntity
    {
        return $this->swagDemo;
    }

    public function setSwagDemo(?SwagDemoEntity $swagDemo): void
    {
        $this->swagDemo = $swagDemo;
    }

    public function getLanguage(): ?LanguageEntity
    {
        return $this->language;
    }

    public function setLanguage(?LanguageEntity $language): void
    {
        $this->language = $language;
    }
}
