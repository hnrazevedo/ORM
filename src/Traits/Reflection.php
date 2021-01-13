<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\Attributes\Entity;

trait Reflection
{
    protected Entity $entity;

    protected function interpret(): void
    {
        $rom = new \ReflectionClass($this::class);
        $this->interpretClass($rom);
        $this->interpretProperties($rom);
    }

    private function interpretClass(\ReflectionClass $rom): void
    {
        $attributes = $rom->getAttributes();

        foreach ($attributes as $attribute) {
            if('HnrAzevedo\ORM\Attributes' !== (new \ReflectionClass($attribute->newInstance()::class))->getNamespaceName()){
                continue;
            }
            $this->entity = $attribute->newInstance();
        }
    }

    private function interpretProperties(\ReflectionClass $rom): void
    {
        $properties = $rom->getProperties();
        foreach ($properties as $property) {
        
            foreach ($property->getAttributes() as $attribute) {
                if('HnrAzevedo\ORM\Attributes' !== (new \ReflectionClass($attribute->newInstance()::class))->getNamespaceName()){
                    continue;
                }

                $attr = $attribute->newInstance();

                $this->entity->setProperty(
                    $property->getName(),
                    basename($attribute->getName()), 
                    ('Column' === basename($attribute->newInstance()::class))
                        ? $attr->setName($attr->getName() ?: $property->getName())
                        : $attr
                );

                $this->select[$property->getName()] = true;

            }
         }
    }
}
