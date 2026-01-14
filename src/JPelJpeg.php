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

use lsolesen\pel\PelDataWindow;
use lsolesen\pel\PelEntry;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTiff;

class JPelJpeg implements JPelInterface
{

	private string $file;
	private PelJpeg $jpeg;
	private ?PelExif $exif;
	private PelTiff $tiff;
	private ?PelIfd $ifd0;

	public function __construct(string $file)
	{
		$data = new PelDataWindow(file_get_contents($file));

		$this->file = $file;
		$this->jpeg = new PelJpeg();
		$this->jpeg->load($data);
		$this->exif = $this->jpeg->getExif();

		if ($this->exif === null)
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

		if ($this->ifd0 === null)
		{
			$this->ifd0 = new PelIfd(PelIfd::IFD0);
			$this->tiff->setIfd($this->ifd0);
		}
	}

	public function getExif(): PelExif
	{
		return $this->exif;
	}

	public function setExif(PelExif $exif): void
	{
		$this->jpeg->setExif($exif);
		$this->exif = $exif;
		$this->tiff = $this->exif->getTiff();
		$this->ifd0 = $this->tiff->getIfd();

		list($width, $height, $type, $attr) = getimagesize($this->file);

		if ($width > 0 && $height > 0)
		{
			$this->set('IMAGE_WIDTH', $width);
			$this->set('IMAGE_LENGTH', $height);
		}

	}

	public function get(string $name): ?PelEntry
	{
		$ifd = $this->ifd0;

		return $ifd->getEntry(constant("lsolesen\pel\PelTag::$name"));
	}

	public function set(string $name, string $value): self
	{

		$entry = $this->ifd0->getEntry(constant("lsolesen\pel\PelTag::$name"));

		if ($entry === null)
		{
			$entry = new PelEntryAscii(constant("lsolesen\pel\PelTag::$name"), $value);
			$this->ifd0->addEntry($entry);
		}
		else
		{
			$entry->setValue($value);
			$this->ifd0->addEntry($entry);
		}

		return $this;
	}

	public function save(string $file): void
	{
		$this->jpeg->saveFile($file);
	}

}