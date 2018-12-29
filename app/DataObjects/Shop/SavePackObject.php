<?php


namespace App\DataObjects\Shop;


use App\Entity\Shop\Category;
use Illuminate\Http\UploadedFile;

class SavePackObject
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $price;

    /**
     * @var array
     */
    private $groups;

    /**
     * @var string
     */
    private $name;

    /**
     * @var UploadedFile|null
     */
    private $picture;

    /**
     * SavePackObject constructor.
     *
     * @param Category $category
     * @param array $items
     * @param int $price
     * @param string $name
     * @param UploadedFile|null $picture
     * @param array $groups
     */
    public function __construct(
        Category $category,
        array $items,
        int $price,
        string $name,
        ?UploadedFile  $picture,
        array $groups = [])
    {
        $this->category = $category;
        $this->items = $items;
        $this->price = $price;
        $this->name = $name;
        $this->picture = $picture;
        $this->groups = $groups;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UploadedFile|null
     */
    public function getPicture(): ?UploadedFile
    {
        return $this->picture;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }
}