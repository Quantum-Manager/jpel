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
 * Interface JPelInterface
 */
interface JPelInterface
{


    /**
     * @return mixed
     */
    public function getExif();

    /**
     * @param $exif
     * @return mixed
     */
    public function setExif($exif);

    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function save($name);

}