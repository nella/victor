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

use Composer\Package\PackageInterface;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;

class Package
{

	/** @var PackageInterface */
	private $completePackage;

	/** @var PackageInterface */
	private $latestPackage;

	/** @var VersionParser */
	private $versionParser;

	public function __construct(
		PackageInterface $completePackage,
		PackageInterface $latestPackage,
		VersionParser $versionParser
	)
	{
		$this->completePackage = $completePackage;
		$this->latestPackage = $latestPackage;
		$this->versionParser = $versionParser;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->completePackage->getName();
	}

	/**
	 * @return \Composer\Semver\Constraint\ConstraintInterface
	 */
	public function getCurrentVersion()
	{
		if ($this->completePackage->getPrettyVersion() === 'N/A') {
			$constraint = new Constraint('=', '0.0.0.1');
			$constraint->setPrettyString('N/A');
			return $constraint;
		}
		return $this->versionParser->parseConstraints($this->completePackage->getPrettyVersion());
	}

	/**
	 * @return \Composer\Semver\Constraint\ConstraintInterface
	 */
	public function getLatestVersion()
	{
		return $this->versionParser->parseConstraints($this->latestPackage->getPrettyVersion());
	}

	/**
	 * @return bool
	 */
	public function isLatest()
	{
		$constraint = new Constraint('==', $this->latestPackage->getVersion());
		return $constraint->matches($this->getCurrentVersion());
	}

}
