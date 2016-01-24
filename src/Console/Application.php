<?php
/**
 * This file is part of the Nella Project (https://victor.nella.io).
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\Victor\Console;

use Composer\Factory;
use Composer\IO\ConsoleIO;
use Composer\Util\ErrorHandler;
use Nella\Victor\Composer\ComposerAccessor;
use Nella\Victor\Console\Command\ShowCommand;
use Nella\Victor\Victor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{

	/** @var \Composer\IO\ConsoleIO */
	private $io;

	/** @var \Composer\Composer */
	private $composer;

	/** @var ComposerAccessor */
	private $composerAccessor;

	public function __construct()
	{
		parent::__construct('Victor', Victor::VERSION);
	}

	/**
	 * @param InputInterface $input  An Input instance
	 * @param OutputInterface $output An Output instance
	 *
	 * @return int 0 if everything went fine, or an error code
	 */
	public function doRun(InputInterface $input, OutputInterface $output)
	{
		$this->io = new ConsoleIO($input, $output, $this->getHelperSet());
		ErrorHandler::register($this->io);

		return parent::doRun($input, $output);
	}

	/**
	 * @return \Composer\Composer
	 */
	public function getComposer()
	{
		if ($this->composer === NULL) {
			try {
				$this->composer = Factory::create($this->io, NULL, FALSE);
			} catch (\InvalidArgumentException $e) {
				$this->io->writeError($e->getMessage());
				exit(1);
			} catch (\Composer\Json\JsonValidationException $e) {
				$errors = ' - ' . implode(PHP_EOL . ' - ', $e->getErrors());
				$message = $e->getMessage() . ':' . PHP_EOL . $errors;
				throw new \Composer\Json\JsonValidationException($message);
			}
		}

		return $this->composer;
	}

	/**
	 * Initializes all the composer commands
	 */
	protected function getDefaultCommands()
	{
		$commands = parent::getDefaultCommands();
		$commands[] = new ShowCommand($this->getComposerAccessor());

		$this->setDefaultCommand(ShowCommand::NAME);

		return $commands;
	}

	/**
	 * @return ComposerAccessor
	 */
	private function getComposerAccessor()
	{
		if ($this->composerAccessor === NULL) {
			$this->composerAccessor = new ComposerAccessor(function () {
				return $this->getComposer();
			});
		}

		return $this->composerAccessor;
	}

}
