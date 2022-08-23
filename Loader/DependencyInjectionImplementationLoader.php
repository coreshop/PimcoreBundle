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

namespace CoreShop\Bundle\PimcoreBundle\Loader;

use CoreShop\Component\Pimcore\Document\DocumentTagFactoryInterface;
use CoreShop\Component\Registry\ServiceRegistryInterface;
use Pimcore\Loader\ImplementationLoader\LoaderInterface;
use Pimcore\Model\Document\Editable\EditableInterface;

class DependencyInjectionImplementationLoader implements LoaderInterface
{
    public function __construct(private ServiceRegistryInterface $factories)
    {
    }

    public function supports(string $name): bool
    {
        return $this->factories->has($name);
    }

    public function build(string $name, array $params = []): EditableInterface
    {
        /**
         * @var DocumentTagFactoryInterface $factory
         */
        $factory = $this->factories->get($name);

        return $factory->create($name, $params);
    }
}
