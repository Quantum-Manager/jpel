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

/**
 * Class JPelTiff
 */
class JPelTiff implements JPelInterface
{

    private $jpeg;
    private $exif;

    public function __construct($file)
    {
        JLoader::registerNamespace('lsolesen\pel', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel');
        $this->jpeg = new PelTiff($file);
        $this->exif = $this->jpeg->getExif();
    }

    public function get($name)
    {
    }

    public function getAll()
    {
    }

    public function set($name, $value)
    {
    }

}