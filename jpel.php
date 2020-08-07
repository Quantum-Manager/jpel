<?php
/**
 * @package    jinterventionimage
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://delo-design.ru
 */

defined('_JEXEC') or die;

class JPel
{

    public function exifJpeg($file)
    {
        JLoader::registerNamespace('lsolesen\pel', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel');

        $exif = new PelExif();
        $jpeg->setExif($exif);
        return $jpeg;
    }

}