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
use Composer\Repository\CompositeRepository;
use Composer\Semver\VersionParser;

class DependencyResolverFactory
{

	/** @var ComposerAccessor */
	private $composerAccessor;

	public function __construct(ComposerAccessor $composerAccessor)
	{
		$this->composerAccessor = $composerAccessor;
	}

	public function create()
	{
		return new DependencyResolver(
			$this->getComposer()->getRepositoryManager()->getLocalRepository(),
			$this->getPool(),
			$this->getPolicy(),
			$this->getVersionParser()
		);
	}

	/**
	 * @return \Composer\Repository\CompositeRepository
	 */
	private function getRepository()
	{
		return new CompositeRepository($this->getComposer()->getRepositoryManager()->getRepositories());
	}

	/**
	 * @return \Composer\DependencyResolver\Pool
	 */
	private function getPool()
	{
		$pool = new Pool(
			$this->getCurrentPackage()->getMinimumStability(),
			$this->getCurrentPackage()->getStabilityFlags()
		);
		$pool->addRepository($this->getRepository());
		return $pool;
	}

	/**
	 * @return \Composer\DependencyResolver\DefaultPolicy
	 */
	private function getPolicy()
	{
		return new DefaultPolicy($this->getCurrentPackage()->getPreferStable());
	}

	/**
	 * @return \Composer\Semver\VersionParser
	 */
	private function getVersionParser()
	{
		return new VersionParser();
	}

	/**
	 * @return \Composer\Package\RootPackageInterface
	 */
	private function getCurrentPackage()
	{
		return $this->getComposer()->getPackage();
	}

	/**
	 * @return \Composer\Composer
	 */
	private function getComposer()
	{
		return $this->composerAccessor->getComposer();
	}

}
