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

require_once JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

class JPel
{

	public static function instance($file)
	{
		$nameSplit = explode('.', $file);
		$exs       = mb_strtolower(array_pop($nameSplit));

		if (in_array($exs, ['jpg', 'jpeg']))
		{
			return new JPelJpeg($file);
		}

		return false;
	}

}