<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2011
 * @author     Kamil Kuźmiński <kamil.kuzminski@gmail.com> 
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */

 
/**
 * Add a palette to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['eventselect'] = '{type_legend},type,name,label;{options_legend},calendars,orderBy,disableGroups;{fconfig_legend},mandatory,multiple;{expert_legend:hide},class,accesskey;{submit_legend},addSubmit';


/**
 * Add a field to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['calendars'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['calendars'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'foreignKey'              => 'tl_calendar.title',
	'eval'                    => array('mandatory'=>true, 'multiple'=>true)
);
 
$GLOBALS['TL_DCA']['tl_form_field']['fields']['orderBy'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['orderBy'],
	'default'                 => 'title_asc',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('title_asc', 'title_desc', 'startDate_asc', 'startDate_desc'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['orderBy'],
	'eval'                    => array('tl_class'=>'w50')
);
 
$GLOBALS['TL_DCA']['tl_form_field']['fields']['disableGroups'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['disableGroups'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12')
);
 