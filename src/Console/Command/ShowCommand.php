<?php
/**
 * This file is part of the Nella Project (https://victor.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\Victor\Console\Command;

use Composer\Package\Link;
use Composer\Repository\PlatformRepository;
use Nella\Victor\Composer\ComposerAccessor;
use Nella\Victor\Composer\DependencyResolverFactory;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends \Symfony\Component\Console\Command\Command
{

	const NAME = 'show';
	const OPTION_IGNORE_REQUIRED_VERSION = 'ignore-required-version';
	const OPTION_EXACT_AS_TILDA = 'exact-as-tilda';
	const EXIT_CODE_UP_TO_DATE = 0;
	const EXIT_CODE_OUTDATED = 1;

	/** @var ComposerAccessor */
	private $composerAccessor;

	public function __construct(ComposerAccessor $composerAccessor)
	{
		parent::__construct();

		$this->composerAccessor = $composerAccessor;
	}

	protected function configure()
	{
		$this->setName(self::NAME);
		$this->setDescription('Check versions updates');

		$this->addOption(
			self::OPTION_IGNORE_REQUIRED_VERSION,
			'f',
			InputOption::VALUE_NONE,
			'Ignore versions required in composer.json.'
		);

		$this->addOption(
			self::OPTION_EXACT_AS_TILDA,
			't',
			InputOption::VALUE_NONE,
			'Exact versions composer.json parsed as tilda.'
		);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$dependencyResolverFactory = new DependencyResolverFactory($this->composerAccessor);
		$dependencyResolver = $dependencyResolverFactory->create();

		$table = new Table($output);
		$table->setHeaders([
			'Package',
			'Current',
			'Latest',
		]);

		$packages = $dependencyResolver->getPackages(
			$this->getRequiredPackages(),
			$input->getOption(self::OPTION_IGNORE_REQUIRED_VERSION),
			$input->getOption(self::OPTION_EXACT_AS_TILDA)
		);
		$versionStatus = self::EXIT_CODE_UP_TO_DATE;
		foreach ($packages as $package) {
			$currentVersion = $package->getCurrentVersion()->getPrettyString();
			if (!$package->isLatest()) {
				$currentVersion = sprintf('<error>%s</error>', $currentVersion);
				$versionStatus = self::EXIT_CODE_OUTDATED;
			}

			$table->addRow([
				$package->getName(),
				$currentVersion,
				$package->getLatestVersion()->getPrettyString(),
			]);
		}

		$table->render();

		return $versionStatus;
	}

	/**
	 * @return Link[]
	 */
	private function getRequiredPackages()
	{
		$platformRepository = $this->getPlatformRepository();

		$packages = array_merge($this->getCurrentPackage()->getRequires(), $this->getCurrentPackage()->getDevRequires());
		return array_filter($packages, function (Link $package) use ($platformRepository) {
			return $platformRepository->findPackage($package->getTarget(), $package->getConstraint()) === NULL;
		});
	}

	/**
	 * @return \Composer\Repository\PlatformRepository
	 */
	private function getPlatformRepository()
	{
		$platformOverrides = $this->getComposer()->getConfig()->get('platform') ?: [];
		return new PlatformRepository([], $platformOverrides);
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
