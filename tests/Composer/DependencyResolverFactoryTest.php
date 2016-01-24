<?php
/**
 * This file is part of the Nella Project (https://victor.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\Victor\Composer;

class DependencyResolverFactoryTest extends \Nella\Victor\ComposerTestCase
{

	public function testCreate()
	{
		$factory = new DependencyResolverFactory($this->getComposerAccessor());
		$this->assertInstanceOf(DependencyResolver::class, $factory->create());
	}

}
