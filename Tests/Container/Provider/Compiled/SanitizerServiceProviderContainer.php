<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Viserio\Component\Validation\Tests\Container\Provider\Compiled;

/**
 * This class has been auto-generated by Viserio Container Component.
 */
final class SanitizerServiceProviderContainer extends \Viserio\Component\Container\AbstractCompiledContainer
{
    /**
     * Create a new Compiled Container instance.
     */
    public function __construct()
    {
        $this->services = $this->privates = [];
        $this->methodMapping = [
            \Viserio\Component\Validation\Sanitizer::class => 'getf4a425bcfa1f3aa2ae65f2afa153b854800f56ef6dd630315701d4c922a06d08',
        ];
        $this->aliases = [
            'sanitizer' => \Viserio\Component\Validation\Sanitizer::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRemovedIds(): array
    {
        return [
            \Psr\Container\ContainerInterface::class => true,
            \Viserio\Contract\Container\Factory::class => true,
            \Viserio\Contract\Container\TaggedContainer::class => true,
            'container' => true,
        ];
    }

    /**
     * Returns the public Viserio\Component\Validation\Sanitizer shared service.
     *
     * @return \Viserio\Component\Validation\Sanitizer
     */
    protected function getf4a425bcfa1f3aa2ae65f2afa153b854800f56ef6dd630315701d4c922a06d08(): \Viserio\Component\Validation\Sanitizer
    {
        $this->services[\Viserio\Component\Validation\Sanitizer::class] = $instance = new \Viserio\Component\Validation\Sanitizer();

        $instance->setContainer($this);

        return $instance;
    }
}