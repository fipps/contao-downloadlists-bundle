<?php
/**
 *  Copyright Information
 *  @copyright: 2018 agentur fipps e.K.
 *  @author   : Arne Borchert
 *  @license  : LGPL 3.0+
 */

// Palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['dllist'] = '{type_legend},type,headline;
                                                            {dllist_legend},dllist;
                                                            {preview_legend},size,perRow;
                                                            {template_legend:hide},dllistTpl;
                                                            {protected_legend:hide},protected;
                                                            {expert_legend:hide},guests,invisible,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['dllist']    = array(
    'label'      => &$GLOBALS['TL_LANG']['tl_content']['dllist'],
    'exclude'    => true,
    'inputType'  => 'select',
    'foreignKey' => 'tl_dllist.title',
    'eval'       => array(
        'mandatory'          => true,
        'chosen'             => true,
        'includeBlankOption' => true,
        'tl_class'           => 'w50',
    ),
    'sql'        => "int(10) unsigned NOT NULL default '0'",
//    'relation'   => array(
//        'type' => 'hasOne',
//        'load' => 'lazy',
//    ),
);
$GLOBALS['TL_DCA']['tl_content']['fields']['dllistTpl'] = array(
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['dllistTpl'],
    'exclude'          => true,
    'default'          => 'ce_downloadlist',
    'inputType'        => 'select',
    'options_callback' => array(
        'tl_content_dllist',
        'getDllistTemplates',
    ),
    'eval'             => array(
        'mandatory' => true,
        'chosen'    => true,
        'tl_class'  => 'w50',
    ),
    'sql'              => "varchar(64) NOT NULL default ''",
);

/**
 * Class tl_content_dllist
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author    Arne Borchert <arne.borchert@fipps.de>
 * @link      http://www.fipps.de
 * @license   LGPL 3.0+
 * @copyright 2018, agentur fipps e.K.
 */
class tl_content_dllist extends tl_content
{

    /**
     * Return all dllist templates as array
     *
     * @param DataContainer $dc
     * @return array
     */
    public function getDllistTemplates()
    {
        return $this->getTemplateGroup('downloadlist');
    }
}
