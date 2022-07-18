<?php
/**
 * @package    jpel
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://delo-design.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Version;
use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelEntryUndefined;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelTiff;

JLoader::register('JPelInterface', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel' . DIRECTORY_SEPARATOR . 'jpelinterface.php');

/**
 * Class JPelJpeg
 */
class JPelJpeg implements JPelInterface
{

    private $file;
    private $jpeg;
    private $exif;
    private $tiff;
    private $ifd0;

    /**
     * JPelJpeg constructor.
     * @param $file
     * @throws \lsolesen\pel\PelInvalidArgumentException
     * @throws \lsolesen\pel\PelInvalidDataException
     * @throws \lsolesen\pel\PelJpegInvalidMarkerException
     */
    public function __construct($file)
    {
        $jversion = new Version();
        if (version_compare($jversion->getShortVersion(), '4.0', '<')) {
			// only for Joomla 3.x
                JLoader::registerNamespace('lsolesen\pel', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel');

		} else {
			// only for Joomla 4.x
            JLoader::registerNamespace('lsolesen\pel', JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'jpel'. DIRECTORY_SEPARATOR . 'lsolesen'. DIRECTORY_SEPARATOR . 'pel');
		}
        $data = new PelDataWindow(file_get_contents($file));

        $this->file = $file;
        $this->jpeg = new PelJpeg();
        $this->jpeg->load($data);
        $this->exif = $this->jpeg->getExif();

        if($this->exif === null)
        {
            $this->exif = new PelExif();
            $this->tiff = new PelTiff();

            $this->exif->setTiff($this->tiff);
            $this->jpeg->setExif($this->exif);
        }
        else
        {
            $this->tiff = $this->exif->getTiff();
        }

        $this->ifd0 = $this->tiff->getIfd();

        if($this->ifd0 === null)
        {
            $this->ifd0 = new PelIfd(PelIfd::IFD0);
            $this->tiff->setIfd($this->ifd0);
        }
    }

    /**
     * @return PelExif
     */
    public function getExif()
    {
        return $this->exif;
    }

    /**
     * @param $exif
     * @return mixed|void
     */
    public function setExif($exif)
    {
        $this->jpeg->setExif($exif);
        $this->exif = $exif;
        $this->tiff = $this->exif->getTiff();
        $this->ifd0 = $this->tiff->getIfd();

        //актуализируем размер изображения
        list($width, $height, $type, $attr) = getimagesize($this->file);

        if($width > 0 && $height > 0)
        {
            $this->set('IMAGE_WIDTH', $width);
            $this->set('IMAGE_LENGTH', $height);
        }

    }

    /**
     * @param $name
     * @return mixed|string|null
     */
    public function get($name)
    {
        $ifd = $this->ifd0;
        $entry = $ifd->getEntry(constant("lsolesen\pel\PelTag::$name"));

        if($entry !== null)
        {
            $entry->getText();
            return $entry->getText();
        }

        return $entry;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed|void
     * @throws \lsolesen\pel\PelException
     * @throws \lsolesen\pel\PelInvalidDataException
     */
    public function set($name, $value)
    {
        $entry = $this->ifd0->getEntry("lsolesen\pel\PelTag::$name");

        if($entry === null)
        {
            $entry = new PelEntryAscii(constant("lsolesen\pel\PelTag::$name"), $value);
            $this->ifd0->addEntry($entry);
        }
        else
        {
            $entry->setValue($value);
            $this->ifd0->addEntry($entry);
        }

    }

    /**
     * @param $file
     * @return mixed|void
     */
    public function save($file)
    {
        $this->jpeg->saveFile($file);
    }

}
