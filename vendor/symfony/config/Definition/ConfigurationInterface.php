<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please tampilan the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Configuration interface.
 *
 * @author Victor Berchet <victor@suumit.com>
 */
interface ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     */
    public function getConfigTreeBuilder(): TreeBuilder;
}