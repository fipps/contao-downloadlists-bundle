<?php
/**
 *  Copyright Information
 *  @copyright: 2018 agentur fipps e.K.
 *  @author   : Arne Borchert
 *  @license  : LGPL 3.0+
 */

$GLOBALS['TL_DCA']['tl_dllist'] = array(

    // Config
    'config'   => array(
        'dataContainer'     => 'Table',
        'ctable'            => array(
            'tl_dllist_elements',
        ),
        'enableVersioning'  => true,
        'onsubmit_callback' => array(),
        'ondelete_callback' => array(),
        'sql'               => array(
            'keys' => array(
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list'     => array(
        'sorting' => array(
            'mode'        => 1,
            'fields'      => array(
                'title',
            ),
            'panelLayout' => 'search,sort,filter',
            'flag'        => 1,
        ),

        'label' => array(
            'fields' => array(
                'title',
            ),
            'format' => '%s',
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
                'label' => &$GLOBALS['TL_LANG']['tl_dllist']['edit'],
                'href'  => 'table=tl_dllist_elements',
                'icon'  => 'edit.gif',
            ),
            'dledit' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist']['dledit'],
                'href'  => 'act=edit',
                'icon'  => 'header.gif',
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_dllist']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ),
            'show'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_dllist']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    // Palettes
    'palettes' => array(
        'default' => '{title_legend},title,author,text',
    ),

    // Fields
    'fields'   => array(
        'id'     => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp' => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'title'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_dllist']['title'],
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
        'author' => array(
            'label'      => &$GLOBALS['TL_LANG']['tl_dllist']['author'],
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
        'text'   => array(
            'label'       => &$GLOBALS['TL_LANG']['tl_dllist']['text'],
            'exclude'     => true,
            'inputType'   => 'textarea',
            'eval'        => array(
                'mandatory' => false,
            ),
            'explanation' => 'insertTags',
            'sql'         => "text NULL",
        ),
    ),
);

/**
 * Class tl_dllist
 *
 * Enthält Funktionen einzelner Felder der Konfiguration
 *
 * @package xFippsSem
 *
 */
class tl_dllist extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }
}
