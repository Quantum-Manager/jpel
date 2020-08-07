<?php
/**
 * @package    jpel
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://delo-design.ru
 */

defined('_JEXEC') or die;

/**
 * Class JPel
 */
class JPel
{

    /**
     * @param $file
     * @return bool|JPelJpeg|JPelTiff
     */
    public static function instance($file)
    {
        $nameSplit = explode('.', $file);
        $exs = array_pop($nameSplit);

        if(in_array($exs, ['jpg', 'jpeg']))
        {
            return new JPelJpeg($file);
        }

        if($exs === 'tiff')
        {
            return new JPelTiff($file);
        }

        return false;
    }


}