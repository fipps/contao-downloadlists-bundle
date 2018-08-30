<?php
/**
 * Contao Downloadlists Bundle
 *
 * @copyright 2018 agentur fipps e.K.
 * @author    Arne Borchert
 * @package   fipps\contao-downloadlists-bundle
 * @license   LGPL 3.0+
 */

$GLOBALS['TL_DCA']['tl_dllist_elements'] = array(

    // Config
    'config'   => array(
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_dllist',
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
                'id'        => 'primary',
                'pid'       => 'index',
                'sorting'   => 'index',
                'published' => 'index',
            ),
        ),
    ),

    // List
    'list'     => array(
        'sorting' => array(
            'mode'                  => 4,
            'fields'                => array(
                'sorting',
            ),
            'panelLayout'           => 'search,filter',
            'headerFields'          => array(
                'title',
            ),
            'child_record_callback' => array(
                'tl_dllist_elements',
                'addPreviewImage',
            ),
        ),

        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ),
        ),

        'operations' => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist_elements']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist_elements']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_dllist_elements']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ),
            'toggle' => array(
                'label'           => &$GLOBALS['TL_LANG']['tl_dllist_elements']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array(
                    'tl_dllist_elements',
                    'toggleIcon',
                ),
            ),
            'show'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist_elements']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    // Palettes
    'palettes' => array(
        'default' => '{title_legend},title,alt;
                        {files_legend},imgSRC,fileSRC;
                        {published_legend},published',
    ),

    // Fields
    'fields'   => array(
        'id'        => array(
            'eval' => array(
                'doNotCopy' => true,
            ),
            'sql'  => "int(10) unsigned NOT NULL auto_increment",
        ),
        'pid'       => array(
            'foreignKey' => 'tl_dllist.title',
            'relation'   => array(
                'type' => 'belongsTo',
                'load' => 'lazy',
            ),
            'sql'        => "int(10) unsigned NOT NULL default '0'",
        ),
        'tstamp'    => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'sorting'   => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'author'    => array(
            'label'      => &$GLOBALS['TL_LANG']['tl_dllist_elements']['author'],
            'default'    => BackendUser::getInstance()->id,
            'exclude'    => true,
            'inputType'  => 'select',
            'foreignKey' => 'tl_user.name',
            'eval'       => array(
                'doNotCopy'          => true,
                'mandatory'          => true,
                'chosen'             => true,
                'includeBlankOption' => true,
                'tl_class'           => 'w50',
            ),
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => array(
                'type' => 'hasOne',
                'load' => 'eager',
            ),
        ),
        'title'     => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist_elements']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array(
                'mandatory' => true,
                'maxlength' => 255,
                'tl_class'  => 'w50',
            ),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'alt'       => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist_elements']['alt'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array(
                'maxlength' => 255,
                'tl_class'  => 'w50',
            ),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'imgSRC'    => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist_elements']['imgSRC'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array(
                'mandatory'  => true,
                'fieldType'  => 'radio',
                'files'      => true,
                'extensions' => 'gif,png,jpg',
            ),
            'sql'       => "binary(16) NULL",
        ),
        'fileSRC'   => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist_elements']['fileSRC'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array(
                'mandatory' => true,
                'fieldType' => 'radio',
                'files'     => true,
            ),
            'sql'       => "binary(16) NULL",
        ),
        'published' => array(
            'exclude'   => true,
            'default'   => 1,
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist_elements']['published'],
            'inputType' => 'checkbox',
            'filter'    => true,
            'eval'      => array(
                'doNotCopy' => true,
            ),
            'sql'       => "char(1) NOT NULL default ''",
        ),
    ),
);

/**
 * Class tl_dllist_elements
 *
 * Enthält Funktionen einzelner Felder der Konfiguration
 *
 * @package xFippsSem
 *
 */
class tl_dllist_elements extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Return the "toggle visibility" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen($this->Input->get('tid'))) {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_dllist_elements::published', 'alexf')) {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published']) {
            $icon = 'invisible.gif';
        }

        $objPage = $this->Database->prepare("SELECT * FROM tl_dllist_elements WHERE id=?")->limit(1)->execute($row['pid']);

        if (!$this->User->isAdmin && !$this->User->isAllowed(4, $objPage->row())) {
            return \Image::getHtml($icon).' ';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
    }

    /**
     * Disable/enable Seminar
     *
     * @param integer $intId
     * @param boolean $isVisible
     */
    public function toggleVisibility($intId, $isVisible)
    {
        // Check permissions to edit
        $this->Input->setGet('id', $intId);
        $this->Input->setGet('act', 'toggle');
        // $this->checkPermission();

        // Check permissions to publish
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_dllist_elements::published', 'alexf')) {
            $this->log('Not enough permissions to publish/unpublish tl_dllist_elements ID "'.$intId.'"', 'tl_dllist_elements toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        \Versions::create('tl_dllist_elements', $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_dllist_elements']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_dllist_elements']['fields']['published']['save_callback'] as $callback) {
                $this->import($callback[0]);
                $isVisible = $this->$callback[0]->$callback[1]($isVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_dllist_elements SET tstamp=".time().", published='".($isVisible ? 1 : '')."' WHERE id=?")->execute($intId);

        \Versions::create('tl_dllist_elements', $intId);
    }

    /**
     * Add an image to each record
     *
     * @param array  $row
     * @param string $label
     * @return string
     */
    public function addPreviewImage($row)
    {
        $fileModel = \FilesModel::findByUuid($row['imgSRC']);
        if ($fileModel === null) {
            $label = $row['title'];
        } else if (is_file(TL_ROOT.'/'.$fileModel->path)) {
            $label = '<img src="'.TL_FILES_URL.\Image::get($fileModel->path, 160, 120, 'center_top').'" width="160" height="120" alt="" class="theme_preview"><br>'.$row['title'];
        }

        return $label;
    }
}
