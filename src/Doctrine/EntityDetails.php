<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Doctrine;

use Doctrine\Common\Persistence\Mapping\ClassMetadata as LegacyClassMetadata;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

/**
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 *
 * @internal
 */
final class EntityDetails
{

    private $metadata;


    /**
     * @param ClassMetadata|LegacyClassMetadata $metadata
     */
    public function __construct( $metadata )
    {
        $this->metadata = $metadata;
    }


    public function getRepositoryClass(): ?string
    {
        return $this->metadata->customRepositoryClassName;
    }


    public function getInterfaceClass(): ?string
    {
        $interfaces = $this->metadata->getReflectionClass()->getInterfaces();
        /** @var \ReflectionClass $interface */
        $interface = array_pop( $interfaces );

        return $interface->getName();
    }


    public function getIdentifier()
    {
        return $this->metadata->identifier[0];
    }


    public function getDisplayFields(): array
    {
        return $this->metadata->fieldMappings;
    }


    public function getFormFields(): array
    {
        $fields = (array)$this->metadata->fieldNames;

        // Remove the primary key field if it's not managed manually
        if( !$this->metadata->isIdentifierNatural() ) {
            $fields = array_diff( $fields, $this->metadata->identifier );
        }
        $fields = array_values( $fields );

        if( !empty( $this->metadata->embeddedClasses ) ) {
            foreach( array_keys( $this->metadata->embeddedClasses ) as $embeddedClassKey ) {
                $fields = array_filter( $fields, function ( $v ) use ( $embeddedClassKey ) {
                    return 0 !== strpos( $v, $embeddedClassKey . '.' );
                } );
            }
        }

        foreach( $this->metadata->associationMappings as $fieldName => $relation ) {
            if( \Doctrine\ORM\Mapping\ClassMetadata::ONE_TO_MANY !== $relation['type'] ) {
                $fields[] = $fieldName;
            }
        }

        $fieldsWithTypes = [];
        foreach( $fields as $field ) {
            $property  = $this->metadata->getReflectionClass()->getProperty( $field );
            $className = Str::getShortClassName( $property->getDeclaringClass()->getName() );

            /** @var \ReflectionAttribute $attribute */
            $attribute = $property->getAttributes()[0];

            $options = [];

            $options[] = '\'label\' => \'' . Str::asSnakeCase( $className ) . '.parameter.' . Str::asSnakeCase( $field ) . '\'';

            $arguments = $attribute->getArguments();

            if( array_key_exists( 'type', $arguments ) ) {
                switch($arguments['type']){
                    case 'string':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\TextType';
                        break;
                    case 'text':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
                        break;
                    case 'boolean':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\CheckboxType';
                        break;
                    case 'float':
                    case 'decimal':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\NumberType';
                        break;
                    case 'integer':
                    case 'smallint':
                    case 'bigint':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\IntegerType';
                        break;
                    case 'date':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\DateType';
                        $options[] = '\'widget\' => \'single_text\'';
                        break;
                    case 'time':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\TimeType';
                        $options[] = '\'widget\' => \'single_text\'';
                        break;
                    case 'datetime':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\DateTimeType';
                        $options[] = '\'date_widget\' => \'single_text\'';
                        $options[] = '\'time_widget\' => \'single_text\'';
                        break;
                    case 'dateinterval':
                        $test['type'] = 'Symfony\Component\Form\Extension\Core\Type\DateIntervalType';
                        break;

                }
            }

            if( array_key_exists( 'targetEntity', $arguments ) ) {
                $test['type'] = 'Symfony\Bridge\Doctrine\Form\Type\EntityType';
                $options[] = '\'class\' => $this->getClassName(\''.$arguments['targetEntity'].'\')';
                $options[] = '\'choice_label\' => \'id\'';

                if($attribute->getName() === ManyToMany::class){
                    $options[] = '\'multiple\' => true';
                    $options[] = '\'expanded\' => false';

                }
            }

            $test['options_code'] = implode( ',' . chr( 10 ), $options );

            $fieldsWithTypes[$field] = $test;
        }

        return $fieldsWithTypes;
    }
}
