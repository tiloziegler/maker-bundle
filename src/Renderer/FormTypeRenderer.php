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
final class FormTypeRenderer
{
    private $generator;

    private $doctrineHelper;

    public function __construct(Generator $generator, DoctrineHelper $doctrineHelper)
    {
        $this->generator = $generator;
        $this->doctrineHelper = $doctrineHelper;
    }

    public function render(ClassNameDetails $formClassDetails, array $formFields, ClassNameDetails $boundClassDetails = null, array $constraintClasses = [], array $extraUseClasses = []): void
    {
        $fieldTypeUseStatements = [];
        $fields = [];

        foreach ($formFields as $name => $fieldTypeOptions) {
            $fieldTypeOptions = $fieldTypeOptions ?? ['type' => null, 'options_code' => '\'label\' => \'label\''
                ];

            if (isset($fieldTypeOptions['type'])) {
                $fieldTypeUseStatements[] = $fieldTypeOptions['type'];
                $fieldTypeOptions['type'] = Str::getShortClassName($fieldTypeOptions['type']);
            }

            $fields[$name] = $fieldTypeOptions;
        }

        $mergedTypeUseStatements = array_unique(array_merge($fieldTypeUseStatements, $extraUseClasses));
        sort($mergedTypeUseStatements);

        $entityDoctrineDetails = $this->doctrineHelper->createDoctrineDetails($boundClassDetails->getFullName());

        $interaceVars = [];

        if (null !== $entityDoctrineDetails->getInterfaceClass()) {
            $interaceClassDetails = $this->generator->createClassNameDetails(
                '\\'.$entityDoctrineDetails->getInterfaceClass(),
                'lib\\Interfaces\\',
                'Interface'
            );

            $interaceVars = [
                'interface_full_class_name' => $interaceClassDetails->getFullName(),
                'interface_class_name' => $interaceClassDetails->getShortName()
            ];
        }
        
        $this->generator->generateClass(
            $formClassDetails->getFullName(),
            'form/Type.tpl.php',
            array_merge([
                    'bounded_full_class_name' => $boundClassDetails ? $boundClassDetails->getFullName() : null,
                    'bounded_class_name' => $boundClassDetails ? $boundClassDetails->getShortName() : null,
                    'form_fields' => $fields,
                    'field_type_use_statements' => $mergedTypeUseStatements,
                    'constraint_use_statements' => $constraintClasses,
                ],
                $interaceVars
            )
        );
    }
}
