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

use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends \Symfony\Component\Console\Command\Command
{

	const NAME = 'self-update';

	/** @var \Humbug\SelfUpdate\Updater */
	private $updater;

	public function __construct(Updater $updater)
	{
		parent::__construct();

		$this->updater = $updater;
	}

	protected function configure()
	{
		$this->setName(self::NAME);
		$this->setAliases(['selfupdate']);
		$this->setDescription('Update Victor to latest version');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try {
			$result = $this->updater->update();

			if ($result) {
				$output->writeln('<info>Victor is sucessfully updated.</info>');
			} else {
				$output->writeln('<info>You are using latest version of Victor no updates needed.</info>');
			}
		} catch (\Exception $e) {
			$output->writeln('<error>Ther is error when update is in progress. Please try it again later.</error>');
			return 255;
		}
	}

}
