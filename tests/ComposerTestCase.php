<?php
/**
 * This file is part of the Nella Project (https://victor.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\Victor;

use Composer\Composer;
use Composer\Config;
use Composer\Package\RootPackageInterface;
use Composer\Repository\ArrayRepository;
use Composer\Repository\RepositoryManager;
use Mockery;
use Nella\Victor\Composer\ComposerAccessor;

abstract class ComposerTestCase extends \Nella\Victor\TestCase
{

	/**
	 * @return ComposerAccessor
	 */
	protected function getComposerAccessor()
	{
		return new ComposerAccessor(function () {
			return $this->getComposer();
		});
	}

	/**
	 * @return Composer
	 */
	protected function getComposer()
	{
		$repository = new ArrayRepository([
			$this->getComposerPackage(),
		]);

		/** @var RepositoryManager|\Mockery\Mock $repositoryManager */
		$repositoryManager = Mockery::mock(RepositoryManager::class);
		$repositoryManager->shouldReceive('getRepositories')->andReturn([$repository]);
		$repositoryManager->shouldReceive('getLocalRepository')->andReturn($repository);

		/** @var RootPackageInterface|\Mockery\Mock $package */
		$package = Mockery::mock(RootPackageInterface::class);
		$package->shouldReceive('getMinimumStability')->andReturn('stable');
		$package->shouldReceive('getStabilityFlags')->andReturn([]);
		$package->shouldReceive('getPreferStable')->andReturn(TRUE);
		$package->shouldReceive('getRequires')->andReturn([$this->getComposerPackageLink()]);
		$package->shouldReceive('getDevRequires')->andReturn([]);

		/** @var Config|\Mockery\Mock $config */
		$config = Mockery::mock(Config::class);
		$config->shouldReceive('get')->with('platform')->andReturn([]);

		/** @var Composer|\Mockery\Mock $composer */
		$composer = Mockery::mock(Composer::class);
		$composer->shouldReceive('getRepositoryManager')->andReturn($repositoryManager);
		$composer->shouldReceive('getPackage')->andReturn($package);
		$composer->shouldReceive('getConfig')->andReturn($config);

		return $composer;
	}

}
