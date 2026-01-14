<?php

namespace Joomla\Libraries\JPel;

/**
 * @package    jpel
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://delo-design.ru
 */

defined('_JEXEC') or die;

use lsolesen\pel\PelExif;

interface JPelInterface
{

	public function getExif(): PelExif;

	public function setExif(PelExif $exif): void;

	public function get(string $name);

	public function set(string $name, string$value): self;

	public function save(string $file): void;

}