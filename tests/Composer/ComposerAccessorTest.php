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

use Composer\Composer;
use Mockery;

class ComposerAccessorTest extends \Nella\Victor\TestCase
{

	public function testGetComposer()
	{
		$accessor = new ComposerAccessor(function () {
			return Mockery::mock(Composer::class);
		});

		$this->assertInstanceOf(Composer::class, $accessor->getComposer());
		$this->assertSame($accessor->getComposer(), $accessor->getComposer());
	}

}
