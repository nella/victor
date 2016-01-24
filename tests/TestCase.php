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

use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Semver\VersionParser;
use Mockery;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	/** @var VersionParser */
	private $versionParser;

	protected function setUp()
	{
		parent::setUp();

		$this->versionParser = new VersionParser();
	}

	protected function tearDown()
	{
		parent::tearDown();
		Mockery::close();
	}

	/**
	 * @return VersionParser
	 */
	protected function getVersionParser()
	{
		return $this->versionParser;
	}

	/**
	 * @param string $version
	 * @param string $name
	 * @return Package
	 */
	protected function getComposerPackage($version = 'v1.0.0', $name = 'nella/victor')
	{
		return new Package($name, $this->versionParser->normalize($version), $version);
	}

	/**
	 * @param string $version
	 * @param string $name
	 * @return Link
	 */
	protected function getComposerPackageLink($version = '~1.0.0', $name = 'nella/victor')
	{
		return new Link('nella/victor-test', $name, $this->versionParser->parseConstraints($version));
	}

}
