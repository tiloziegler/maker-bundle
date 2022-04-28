<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;


class <?= $class_name ?>
{

    public const CONFIGURE = '<?= $snake_clase_class_name ?>.menu_configure';


    private FactoryInterface $factory;


    private ItemInterface $menu;


    public function __construct( FactoryInterface $factory, ItemInterface $menu )
    {
        $this->factory = $factory;
        $this->menu    = $menu;
    }


    /**
     * @return FactoryInterface
     */
    public function getFactory(): FactoryInterface
    {
        return $this->factory;
    }


    /**
     * @return ItemInterface
     */
    public function getMenu(): ItemInterface
    {
        return $this->menu;
    }
}
