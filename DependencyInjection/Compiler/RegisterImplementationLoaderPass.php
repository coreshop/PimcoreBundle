<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 */

declare(strict_types=1);

namespace CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

abstract class RegisterImplementationLoaderPass implements CompilerPassInterface
{
    public function __construct(protected string $implementationLoader, protected string $tag)
    {
    }

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition($this->implementationLoader)) {
            return;
        }

        $registry = $container->getDefinition($this->implementationLoader);

        foreach ($container->findTaggedServiceIds($this->tag) as $id => $attributes) {
            $registry->addMethodCall('addLoader', [new Reference($id)]);
        }
    }
}
