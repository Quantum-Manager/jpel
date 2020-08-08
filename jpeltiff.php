<?php
/**
 * @package    jpel
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://delo-design.ru
 */

defined('_JEXEC') or die;

use lsolesen\pel\PelTiff;

JLoader::register('JPelInterface', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel' . DIRECTORY_SEPARATOR . 'jpelinterface.php');

/**
 * Class JPelTiff
 */
class JPelTiff implements JPelInterface
{

    private $tiff;
    private $exif;

    public function __construct($file)
    {
        JLoader::registerNamespace('lsolesen\pel', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel');
        $this->tiff = new PelTiff($file);
        $this->exif = $this->tiff->getExif();
    }

    public function get($name)
    {
    }

    public function set($name)
    {
    }

    public function save($file)
    {
    }

}