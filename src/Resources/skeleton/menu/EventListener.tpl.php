<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use App\Event\ConfigureMenuEvent;

class <?= $class_name ?>
{

    public function addMainMenuIcon( ConfigureMenuEvent $event ): void
    {
        $menu = $event->getMenu();

        $menu->addChild( '<?= $snake_clase_class_name ?>_index', [
            'route' => '<?= $snake_clase_class_name ?>_index',
            'label' => 'menu.<?= $snake_clase_class_name ?>.index'
        ] );
    }
}
