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

use Composer\DependencyResolver\DefaultPolicy;
use Composer\DependencyResolver\Pool;
use Composer\Repository\ArrayRepository;
use Composer\Repository\RepositoryInterface;
use Composer\Semver\Constraint\ConstraintInterface;

class DependencyResolverTest extends \Nella\Victor\TestCase
{

	public function testCurrentLatestTilda()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestTildaTwo()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestCaret()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestExact()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testPatchLatestTilda()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestTildaTwo()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestCaret()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestExact()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMinorLatestTilda()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMinorLatestTildaTwo()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestCaret()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestExact()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMajorLatestTilda()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMajorLatestTildaTwo()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMajorLatestCaret()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testMajorLatestExact()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestTildaIgnore()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink()], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestTildaTwoIgnore()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestCaretIgnore()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testCurrentLatestExactIgnore()
	{
		$repository = $this->getRepository();
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertTrue($package->isLatest());
	}

	public function testPatchLatestTildaIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestTildaTwoIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestCaretIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testPatchLatestExactIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.1', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestTildaIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestTildaTwoIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestCaretIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMinorLatestExactIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.1.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMajorLatestTildaIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v2.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMajorLatestTildaTwoIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v2.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMajorLatestCaretIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('^1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v2.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testMajorLatestExactIgnore()
	{
		$repository = $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$dependencyResolver = new DependencyResolver(
			$repository,
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('1.0.0')], TRUE);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/victor', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('v1.0.0', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v2.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	public function testNoDev()
	{
		$repository = clone $this->getRepository();
		$repository->addPackage($this->getComposerPackage('v1.0.0', 'nella/no-dev'));
		$dependencyResolver = new DependencyResolver(
			$this->getRepository(),
			$this->getPool($repository),
			$this->getPolicy(),
			$this->getVersionParser()
		);

		$packages = $dependencyResolver->getPackages([$this->getComposerPackageLink('~1.0.0', 'nella/no-dev')]);

		$this->assertCount(1, $packages);
		$this->assertArrayHasKey(0, $packages);
		$package = $packages[0];
		$this->assertSame('nella/no-dev', $package->getName());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getCurrentVersion());
		$this->assertSame('--no-dev', $package->getCurrentVersion()->getPrettyString());
		$this->assertInstanceOf(ConstraintInterface::class, $package->getLatestVersion());
		$this->assertSame('v1.0.0', $package->getLatestVersion()->getPrettyString());
		$this->assertFalse($package->isLatest());
	}

	private function getPolicy()
	{
		return new DefaultPolicy();
	}

	/**
	 * @param RepositoryInterface $repository
	 * @return Pool
	 */
	private function getPool(RepositoryInterface $repository)
	{
		$pool = new Pool();
		$pool->addRepository($repository);

		return $pool;
	}

	/**
	 * @return ArrayRepository
	 */
	private function getRepository()
	{
		$repository = new ArrayRepository();
		$repository->addPackage($this->getComposerPackage());
		return $repository;
	}

}
