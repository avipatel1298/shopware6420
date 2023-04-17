<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\SwagDemo;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Country\CountryEntity;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateEntity;
use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Content\Product\ProductEntity;
use SwagDemoPlugin\Core\Content\SwagDemo\Aggregate\SwagDemoTranslation\SwagDemoTranslationCollection;

class SwagDemoEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool|null
     */
    protected $active;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string|null
     */
    protected $notTranslatedField;

    /**
     * @var string|null
     */
    protected $countryId;

    /**
     * @var string|null
     */
    protected $countrystateId;

    /**
     * @var string|null
     */
    protected $mediaId;

    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var CountryEntity|null
     */
    protected $country;

    /**
     * @var CountryStateEntity|null
     */
    protected $countryState;

    /**
     * @var MediaEntity|null
     */
    protected $media;

    /**
     * @var ProductEntity|null
     */
    protected $product;

    /**
     * @var SwagDemoTranslationCollection
     */
    protected $translations;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var array|null
     */
    protected $translated;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getNotTranslatedField(): ?string
    {
        return $this->notTranslatedField;
    }

    public function setNotTranslatedField(?string $notTranslatedField): void
    {
        $this->notTranslatedField = $notTranslatedField;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(?string $countryId): void
    {
        $this->countryId = $countryId;
    }

    public function getCountrystateId(): ?string
    {
        return $this->countrystateId;
    }

    public function setCountrystateId(?string $countrystateId): void
    {
        $this->countrystateId = $countrystateId;
    }

    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    public function setMediaId(?string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): void
    {
        $this->productId = $productId;
    }

    public function getCountry(): ?CountryEntity
    {
        return $this->country;
    }

    public function setCountry(?CountryEntity $country): void
    {
        $this->country = $country;
    }

    public function getCountryState(): ?CountryStateEntity
    {
        return $this->countryState;
    }

    public function setCountryState(?CountryStateEntity $countryState): void
    {
        $this->countryState = $countryState;
    }

    public function getMedia(): ?MediaEntity
    {
        return $this->media;
    }

    public function setMedia(?MediaEntity $media): void
    {
        $this->media = $media;
    }

    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    public function setProduct(?ProductEntity $product): void
    {
        $this->product = $product;
    }

    public function getTranslations(): SwagDemoTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(SwagDemoTranslationCollection $translations): void
    {
        $this->translations = $translations;
    }

    public function getCreatedAt(): \DateTimeInterface
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

    public function getTranslated(): array
    {
        return $this->translated;
    }

    public function setTranslated(?array $translated): void
    {
        $this->translated = $translated;
    }
}