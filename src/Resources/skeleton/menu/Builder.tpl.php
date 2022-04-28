<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $event_full_class_name ?>;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class <?= $class_name ?>
{

    private EventDispatcherInterface $eventDispatcher;


    private FactoryInterface $factory;


    public function __construct( EventDispatcherInterface $eventDispatcher, FactoryInterface $factory )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->factory         = $factory;
    }


    public function build( array $options ): ItemInterface
    {
        $menu = $this->factory->createItem(
            'person',
            [
                'label' => '<?= $snake_clase_class_name ?>.menu'
            ]
        );

        $this->eventDispatcher->dispatch(
            new <?= $event_class_name ?>( $this->factory, $menu ),
            <?= $event_class_name ?>::CONFIGURE
        );

        return $menu;
    }
}
