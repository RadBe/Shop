<?php


namespace App\Handlers\Shop\Admin\Add;


use App\DataObjects\Shop\ItemSaveObject;
use App\Entity\Shop\Item;
use App\Entity\Shop\Type;
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

    public function handle(ItemSaveObject $save): Item
    {
        $item = new Item($save->getType(), $save->getName(), $save->getDescription(), $save->getExtra());

        $this->itemRepository->create($item);

        $this->image($save->getPicture(), $item);

        return $item;
    }

    private function image(UploadedFile $file, Item $item): void
    {
        $fileName = Image::filterName(($item->getExtraArray()['id'] ?? 'item_' . $item->getId()) . '.png');
        $file->move(Image::DIR, $fileName);
    }
}