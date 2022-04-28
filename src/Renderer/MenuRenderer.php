<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Renderer;

use Symfony\Bundle\MakerBundle\Doctrine\DoctrineHelper;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

/**
 * @internal
 */
final class MenuRenderer
{
    private $generator;

    private $doctrineHelper;

    public function __construct(Generator $generator, DoctrineHelper $doctrineHelper)
    {
        $this->generator = $generator;
        $this->doctrineHelper = $doctrineHelper;
    }

    public function renderBuilder(ClassNameDetails $formClassDetails, ClassNameDetails $boundClassDetails, ClassNameDetails $eventClassDetails): void
    {
        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($boundClassDetails->getFullName());
        
        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            'menu/Builder.tpl.php',
            array_merge([
                    'bounded_full_class_name' => $boundClassDetails->getFullName(),
                    'bounded_class_name' => $boundClassDetails->getShortName(),
                    'snake_clase_class_name' => Str::asSnakeCase($boundClassDetails->getShortName()),
                    'event_full_class_name' => $eventClassDetails->getFullName(),
                    'event_class_name' => $eventClassDetails->getShortName()
                ]
            )
        );
    }

    public function renderEvent(ClassNameDetails $formClassDetails, ClassNameDetails $boundClassDetails = null): void
    {
        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($boundClassDetails->getFullName());


        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            'menu/Event.tpl.php',
            array_merge([
                            'bounded_full_class_name' => $boundClassDetails ? $boundClassDetails->getFullName() : null,
                            'bounded_class_name' => $boundClassDetails ? $boundClassDetails->getShortName() : null,
                            'snake_clase_class_name' => $boundClassDetails ? Str::asSnakeCase($boundClassDetails->getShortName()) : null,
                        ]
            )
        );
    }

    public function renderEventListener(ClassNameDetails $formClassDetails, ClassNameDetails $boundClassDetails = null): void
    {
        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($boundClassDetails->getFullName());


        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            'menu/EventListener.tpl.php',
            array_merge([
                            'bounded_full_class_name' => $boundClassDetails ? $boundClassDetails->getFullName() : null,
                            'bounded_class_name' => $boundClassDetails ? $boundClassDetails->getShortName() : null,
                            'snake_clase_class_name' => $boundClassDetails ? Str::asSnakeCase($boundClassDetails->getShortName()) : null,
                        ]
            )
        );
    }
}
