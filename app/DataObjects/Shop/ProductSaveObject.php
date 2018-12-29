<?php


namespace App\DataObjects\Shop;


use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use Illuminate\Http\UploadedFile;

class ProductSaveObject
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var Item|null
     */
    private $item;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $price;

    /**
     * @var array
     */
    private $groups;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var UploadedFile|null
     */
    private $picture;

    /**
     * SaveObject constructor.
     *
     * @param Category $category
     * @param Item $item
     * @param int $amount
     * @param int $price
     * @param array $groups
     * @param null|string $name
     * @param null|UploadedFile $picture
     */
    public function __construct(
        Category $category,
        Item $item,
        int $amount,
        int $price,
        array $groups = [],
        ?string $name = null,
        ?UploadedFile $picture = null)
    {
        $this->category = $category;
        $this->item = $item;
        $this->amount = $amount;
        $this->price = $price;
        $this->groups = $groups;
        $this->name = empty($name) ? null : $name;
        $this->picture = $picture;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return Item|null
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return null|UploadedFile
     */
    public function getPicture(): ?UploadedFile
    {
        return $this->picture;
    }
}