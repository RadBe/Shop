<?php


namespace App\Handlers\Shop\Admin\Edit;


use App\DataObjects\Shop\ItemSaveObject;
use App\Entity\Shop\Item;
use App\Entity\Shop\Type;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Exceptions\Shop\TypeNotFoundException;
use App\Repository\Shop\Item\ItemRepository;
use App\Repository\Shop\Type\TypeRepository;
use App\Services\Shop\Image\Image;
use Illuminate\Http\UploadedFile;

class ItemHandler
{
    private $itemRepository;

    private $typeRepository;

    public function __construct(ItemRepository $itemRepository, TypeRepository $typeRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->typeRepository = $typeRepository;
    }

    public function getTypes(): array
    {
        return $this->typeRepository->getAll();
    }

    public function getType(string $id): Type
    {
        $type = $this->typeRepository->find($id);
        if(is_null($type)) {
            throw new TypeNotFoundException($id);
        }

        return $type;
    }

    public function getItem(int $id): Item
    {
        $item = $this->itemRepository->find($id);
        if(is_null($item)) {
            throw new ItemNotFoundException($id);
        }

        return $item;
    }

    public function handle(ItemSaveObject $save, Item $item): void
    {
        $item->setName($save->getName())
            ->setType($save->getType())
            ->setDescription($save->getDescription())
            ->setExtra($save->getExtra());

        $this->itemRepository->update($item);

        $this->image($save->getPicture(), $item);
    }

    private function image(?UploadedFile $file, Item $item): void
    {
        if(!is_null($file)) {
            $fileName = Image::filterName(($item->getExtraArray()['id'] ?? 'item_' . $item->getId()) . '.png');
            $file->move(Image::DIR, $fileName);
        }
    }
}