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

use Composer\DependencyResolver\PolicyInterface;
use Composer\DependencyResolver\Pool;
use Composer\Package\Link;
use Composer\Package\Package as ComposerPackage;
use Composer\Repository\RepositoryInterface;
use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\VersionParser;

class DependencyResolver
{

	/** @var RepositoryInterface */
	private $repository;

	/** @var Pool */
	private $pool;

	/** @var PolicyInterface */
	private $policy;

	/** @var VersionParser */
	private $versionParser;

	public function __construct(
		RepositoryInterface $repository,
		Pool $pool,
		PolicyInterface $policy,
		VersionParser $versionParser
	)
	{
		$this->repository = $repository;
		$this->pool = $pool;
		$this->policy = $policy;
		$this->versionParser = $versionParser;
	}

	/**
	 * @param \Composer\Package\Link[] $packageLinks
	 * @param bool $ignoreRequiredVersion
	 * @param bool $exactAsTilda
	 * @return Package[]
	 */
	public function getPackages(array $packageLinks, $ignoreRequiredVersion = FALSE, $exactAsTilda = FALSE)
	{
		$latestPackages = $this->getLatestPackages($packageLinks, $ignoreRequiredVersion, $exactAsTilda);

		$packages = [];
		foreach ($packageLinks as $packageLink) {
			$currentPackage = $this->getPackage($packageLink->getTarget(), $packageLink->getConstraint());
			$latestPackage = $latestPackages[$packageLink->getTarget()];

			$packages[] = new Package(
				$currentPackage,
				$latestPackage,
				$this->versionParser
			);
		}

		return $packages;
	}

	/**
	 * @param string $name
	 * @param ConstraintInterface $constraint
	 * @return \Composer\Package\PackageInterface
	 */
	private function getPackage($name, ConstraintInterface $constraint)
	{
		$package = $this->repository->findPackage($name, $constraint);
		if ($package === NULL) {
			return new ComposerPackage($name, '0.0.0.1', '--no-dev');
		}
		return $package;
	}

	/**
	 * @param \Composer\Package\Link[] $packageLinks
	 * @param bool $ignoreRequiredVersion
	 * @param bool $exactAsTilda
	 * @return \Composer\Package\PackageInterface[]
	 */
	private function getLatestPackages(array $packageLinks, $ignoreRequiredVersion = FALSE, $exactAsTilda = FALSE)
	{
		$packageIds = $this->policy->selectPreferredPackages($this->pool, [], $this->getLiterals(
			$packageLinks,
			$ignoreRequiredVersion,
			$exactAsTilda
		));

		$packages = [];
		foreach ($packageIds as $packageId) {
			$package = $this->pool->packageById($packageId);
			$packages[$package->getName()] = $package;
		}

		return $packages;
	}

	/**
	 * @param \Composer\Package\Link[] $packageLinks
	 * @param bool $ignoreRequiredVersion
	 * @param bool $exactAsTilda
	 * @return int[]
	 */
	private function getLiterals(array $packageLinks, $ignoreRequiredVersion = FALSE, $exactAsTilda = FALSE)
	{
		$literals = [];
		foreach ($packageLinks as $packageLink) {
			foreach ($this->getVersionsByPackageLink($packageLink, $ignoreRequiredVersion, $exactAsTilda) as $packageVersion) {
				$literals[] = $packageVersion->getId();
			}
		}

		return array_unique($literals);
	}

	/**
	 * @param \Composer\Package\Link $packageLink
	 * @param bool $ignoreRequiredVersion
	 * @param bool $exactAsTilda
	 * @return \Composer\Package\PackageInterface[]
	 */
	private function getVersionsByPackageLink(Link $packageLink, $ignoreRequiredVersion = FALSE, $exactAsTilda = FALSE)
	{
		$constraint = $packageLink->getConstraint();
		if ($ignoreRequiredVersion && $this->versionParser->parseStability($constraint->getPrettyString()) !== 'dev') {
			$constraint = NULL;
		} elseif ($exactAsTilda && $this->isExact($constraint)) {
			$constraint = $this->versionParser->parseConstraints(sprintf('~%s', $constraint->getPrettyString()));
		}
		return $this->getVersions($packageLink->getTarget(), $constraint);
	}

	/**
	 * @param string $packageName
	 * @param ConstraintInterface|NULL $constraint
	 * @return \Composer\Package\PackageInterface[]
	 */
	private function getVersions($packageName, ConstraintInterface $constraint = NULL)
	{
		return $this->pool->whatProvides($packageName, $constraint, TRUE);
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return bool
	 */
	private function isExact(ConstraintInterface $constraint)
	{
		if ($constraint instanceof \Composer\Semver\Constraint\Constraint) {
			if (strncmp((string) $constraint, '==', 2) === 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

}
