<?php
/**
 * Contao DownloadlistsBundle Bundle
 *
 * @copyright 2018 agentur fipps e.K.
 * @author    Arne Borchert
 * @package   fipps\contao-downloadlists-bundle
 * @license   LGPL 3.0+
 */

namespace Fipps\DownloadlistsBundle;

class ContentDownloadlist extends \ContentGallery
{

    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'ce_gallery';

    protected $arrFileSRC = array();

    protected $arrImgMeta = array();

    /**
     * Parse the template
     *
     * @return string
     */
    public function generate()
    {
        $select    = 'SELECT * FROM tl_dllist_elements WHERE pid = ? ORDER BY sorting';
        $objDllist = $this->Database->prepare($select)->execute($this->dllist);

        if ($objDllist->numRows < 1) {
            return '';
        }

        $arrMultiSRC = array();
        $arrFileSRC  = array();
        $arrImgMeta  = array();
        while ($objDllist->next()) {
            $imgSRC    = 'bundles/fippsdownloadlists/assets/blank.gif';
            $fileSRC   = '';
            $fileModel = \FilesModel::findByUuid($objDllist->imgSRC);
            if ($fileModel != null) {
                $arrMultiSRC[] = $objDllist->imgSRC;
                $imgSRC        = $fileModel->path;
            } else {
                $arrMultiSRC[] = '';
            }

            $fileModel = \FilesModel::findByUuid($objDllist->fileSRC);
            if ($fileModel != null && file_exists(TL_ROOT.'/'.$fileModel->path)) {
                $fileSRC = $fileModel->path;
            }

            $arrFileSRC[] = $fileSRC;
            $arrImgMeta[] = array(
                'alt'      => $objDllist->alt,
                'imageUrl' => TL_ROOT.'/'.$imgSRC,
                'caption'  => $objDllist->title,
            );
        }

        $this->multiSRC   = serialize($arrMultiSRC);
        $this->arrFileSRC = $arrFileSRC;
        $this->arrImgMeta = $arrImgMeta;

        $file = $this->Input->get('file', true);

        // Send the file to the browser
        if ($file != '' && (in_array($file, $arrFileSRC))) {
            $this->sendFileToBrowser($file);
        }
        $this->sortBy = 'custom';

        return parent::generate();
    }

    /**
     * Generate the content element
     */
    protected function compile()
    {
        /** @var \PageModel $objPage */
        global $objPage;

        $this->galleryTpl = 'downloadlist_default';
        if (isset($this->dllistTpl)) {
            $this->galleryTpl = $this->dllistTpl;
        }
        parent::compile();
        foreach ($this->arrFileSRC as $src) {
            $this->Template->images = str_replace('[['.(integer)$count++.']]', $objPage->alias.'.html?file='.$src, $this->Template->images);
        }
        $arrData = $this->arrData;
    }
}