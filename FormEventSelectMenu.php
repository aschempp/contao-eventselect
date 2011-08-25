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


class FormEventSelectMenu extends FormSelectMenu
{

	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'calendars':
				$this->arrCalendars = deserialize($varValue);
				break;
			
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}
	
	
	/**
	 * Return a parameter
	 * @return string
	 * @throws Exception
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'calendars':
				return $this->arrCalendars;
				break;
			
			case 'orderBy':
				return $this->orderBy ? $this->orderBy : 'title_asc';
				break;

			default:
				return parent::__get($strKey);
				break;
		}
	}


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// Return if none calendars were selected
		if (!is_array($this->calendars) || count($this->calendars) < 1)
		{
			return '';
		}

		$this->import('Database');
		
		list($field, $order) = explode('_', $this->orderBy);
	
		// Get all events
		$objEvents = $this->Database->execute("SELECT *" . (!$this->disableGroups ? (", FIELD(pid, " . implode(',', array_map('intval', $this->calendars)) . ") AS sorter") : "") . ", (SELECT title FROM tl_calendar WHERE tl_calendar.id=tl_calendar_events.pid) AS calendarTitle FROM tl_calendar_events WHERE pid IN(" . implode(',', array_map('intval', $this->calendars)) . ")" . (!BE_USER_LOGGED_IN ? " AND published=1" : "") . ((!$this->disableGroups) ? sprintf(" ORDER BY sorter, %s %s", $field, $order) : sprintf(" ORDER BY %s %s", $field, $order)));
		
		$strGroup = '';
		
		while ($objEvents->next())
		{
			// Create group
			if ($strGroup != $objEvents->calendarTitle && !$this->disableGroups)
			{			
				$this->arrOptions[] = array
				(
					'group' => true,
					'label' => $objEvents->calendarTitle
				);
				
				$strGroup = $objEvents->calendarTitle;
			}
			
			$strLabel = specialchars($objEvents->title . ' ' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->startDate) . ($objEvents->endDate ? (' - ' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->endDate)) : ''));
			
			// Add events
			$this->arrOptions[] = array
			(
				'value' => ($strLabel . ' (ID ' . $objEvents->id . ')'),
				'label' => $strLabel,
			);
		}
		
		return parent::generate();
	}
}

