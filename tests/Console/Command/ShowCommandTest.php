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

use Composer\Repository\ArrayRepository;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ShowCommandTest extends \Nella\Victor\ComposerTestCase
{

	public function testRun()
	{
		$command = new ShowCommand($this->getComposerAccessor());

		$input = new StringInput('');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v1.0.0 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

	public function testRunPatchUpdate()
	{
		$composerAccessor = $this->getComposerAccessor();
		/** @var ArrayRepository $repository */
		$repository = $composerAccessor->getComposer()->getRepositoryManager()->getRepositories()[0];
		$repository->addPackage($this->getComposerPackage('v1.0.1'));
		$command = new ShowCommand($composerAccessor);

		$input = new StringInput('');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v1.0.1 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

	public function testRunMinorUpdate()
	{
		$composerAccessor = $this->getComposerAccessor();
		/** @var ArrayRepository $repository */
		$repository = $composerAccessor->getComposer()->getRepositoryManager()->getRepositories()[0];
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$command = new ShowCommand($composerAccessor);

		$input = new StringInput('');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v1.0.0 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

	public function testRunMinorUpdateIgnore()
	{
		$composerAccessor = $this->getComposerAccessor();
		/** @var ArrayRepository $repository */
		$repository = $composerAccessor->getComposer()->getRepositoryManager()->getRepositories()[0];
		$repository->addPackage($this->getComposerPackage('v1.1.0'));
		$command = new ShowCommand($composerAccessor);

		$input = new StringInput('-f');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v1.1.0 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

	public function testRunMajorUpdate()
	{
		$composerAccessor = $this->getComposerAccessor();
		/** @var ArrayRepository $repository */
		$repository = $composerAccessor->getComposer()->getRepositoryManager()->getRepositories()[0];
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$command = new ShowCommand($composerAccessor);

		$input = new StringInput('');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v1.0.0 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

	public function testRunMajorUpdateIgnore()
	{
		$composerAccessor = $this->getComposerAccessor();
		/** @var ArrayRepository $repository */
		$repository = $composerAccessor->getComposer()->getRepositoryManager()->getRepositories()[0];
		$repository->addPackage($this->getComposerPackage('v2.0.0'));
		$command = new ShowCommand($composerAccessor);

		$input = new StringInput('-f');
		$output = new BufferedOutput();
		$command->run($input, $output);

		$expected = '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| Package      | Current | Latest |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;
		$expected .= '| nella/victor | v1.0.0  | v2.0.0 |';
		$expected .= PHP_EOL;
		$expected .= '+--------------+---------+--------+';
		$expected .= PHP_EOL;

		$this->assertSame($expected, $output->fetch());
	}

}
