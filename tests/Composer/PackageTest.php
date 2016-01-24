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

use Composer\Semver\Constraint\ConstraintInterface;

class PackageTest extends \Nella\Victor\TestCase
{

	public function testLatest()
	{
		$package = new Package($this->getComposerPackage(), $this->getComposerPackage(), $this->getVersionParser());

		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testNewest()
	{
		$package = new Package($this->getComposerPackage(), $this->getComposerPackage('v2.0.0'), $this->getVersionParser());

		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v2.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

}
