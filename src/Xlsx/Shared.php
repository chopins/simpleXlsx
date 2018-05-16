<?php

/**
 * Toknot (http://toknot.com)
 *
 * @copyright  Copyright (c) 2011 - 2017 Toknot.com
 * @license    http://toknot.com/LICENSE.txt New BSD License
 * @link       https://github.com/chopins/toknot
 */

namespace Toknot\SimpleXlsx\Xlsx;

use Toknot\Path\File;

/**
 * Shared
 *
 */
class Shared {

    protected $sharedStringCnt = 0;
    protected $sharedAllCnt = 0;
    protected $hasShared = 0;
    protected $workspace = '';
    protected $sharedFileObj = null;
    protected $sharedStringsFile = '/xl/sharedStrings.xml';
    protected $xlsx = null;

    public function __construct(Xlsx $xlsx, $flag) {
        $this->xlsx = $xlsx;
        $this->workspace = $xlsx->getWorkspace();
        $this->openTmpFile($flag);
    }

    public function openTmpFile($flag) {
        $flag = $flag == 'w' ? '.data' : '';
        $path = "{$this->workspace}{$this->sharedStringsFile}{$flag}";

        if ($flag == '.data') {
            $this->sharedFileObj = new File($path, 'a+');
        } else {
            $this->sharedFileObj = new \DOMDocument;
            $this->sharedFileObj->load($path);
        }
    }

    public function addShared(&$str) {
        $this->sharedFileObj->rewind();
        $xml = "<si><t xml:space=\"preserve\">{$str}</t></si>" . PHP_EOL;
        $this->sharedAllCnt++;
        foreach ($this->sharedFileObj as $n => $line) {
            if ($line == $xml) {
                $str = $n;
                return;
            }
        }

        $this->sharedFileObj->fwrite($xml);
        $str = $this->sharedStringCnt;
        $this->hasShared++;
        $this->sharedStringCnt++;
    }

    public function saveShared() {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . $this->sharedAllCnt . '" uniqueCount="' . $this->sharedStringCnt . '">';
        $this->xlsx->saveXml($this->sharedStringsFile, $xml);
        $fp = new File("{$this->workspace}{$this->sharedStringsFile}", 'a+');
        if ($this->hasShared > 0) {
            $this->sharedFileObj->rewind();
            foreach ($this->sharedFileObj as $row) {
                $fp->fwrite(trim($row));
            }
        }
        $fp->fwrite('</sst>');
        $this->sharedFileObj->unlink();
        return $this->sharedStringsFile;
    }

    public function getShared($k) {
        $ts = $this->sharedFileObj->getElementsByTagName('t');
        if ($ts->item($k)) {
            return $ts->item($k)->textContent;
        }
        return false;
    }

}
