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

use Composer\Composer;

class ComposerAccessor
{

	/** @var callable */
	private $accessor;

	/** @var Composer */
	private $composer;

	/**
	 * @param callable $accessor
	 */
	public function __construct($accessor)
	{
		$this->accessor = $accessor;
	}

	/**
	 * @return Composer
	 */
	public function getComposer()
	{
		if ($this->composer === NULL) {
			$this->composer = call_user_func($this->accessor);
		}

		return $this->composer;
	}

}
