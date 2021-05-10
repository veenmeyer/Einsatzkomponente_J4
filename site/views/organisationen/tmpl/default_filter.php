<?php

/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */

defined('JPATH_BASE') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

// Check if any filter field has been filled
$filters = false;

if (isset($data['view']->filterForm))
{
	$filters = $data['view']->filterForm->getGroup('filter');
}

// Check if there are filters set.
if ($filters !== false)
{
	$filterFields = array_keys($filters);
	$filtered     = false;
	$filled       = false;

	foreach ($filterFields as $filterField)
	{
		$filterField = substr($filterField, 7);
		$filter      = $data['view']->getState('filter.' . $filterField);

		if (!empty($filter))
		{
			$filled = $filter;
		}

		if (!empty($filled))
		{
			$filtered = true;
			break;
		}
	}
}

$options = $data['options'];

// Set some basic options
$customOptions = array(
	'filtersHidden'       => isset($options['filtersHidden']) ? $options['filtersHidden'] : empty($data['view']->activeFilters) && !$filtered,
	'defaultLimit'        => isset($options['defaultLimit']) ? $options['defaultLimit'] : Factory::getApplication()->get('list_limit', 20),
	'searchFieldSelector' => '#filter_search',
	'orderFieldSelector'  => '#list_fullordering'
);

$data['options'] = array_unique(array_merge($customOptions, $data['options']));

$formSelector = !empty($data['options']['formSelector']) ? $data['options']['formSelector'] : '#adminForm';

// Load search tools
JHtml::_('searchtools.form', $formSelector, $data['options']);
?>

<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<label for="filter_search" class="element-invisible"
				   aria-invalid="false"><?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_FILTER_SUBMIT'); ?></label>

			<div class="btn-wrapper input-append">
				<?php echo $filters['filter_search']->input; ?>
				<button type="submit" class="btn hasTooltip" title=""
						data-original-title="<?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i>
				</button>
			</div>
			<?php if ($filters): ?>
				<div class="btn-wrapper hidden-phone">
					<button type="button" class="btn hasTooltip js-stools-btn-filter" title=""
							data-original-title="<?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_TOOLS_DESC'); ?>">
						<?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_TOOLS'); ?> <i class="caret"></i>
					</button>
				</div>
			<?php endif; ?>

			<div class="btn-wrapper">
				<button type="button" class="btn hasTooltip js-stools-btn-clear" title=""
						data-original-title="<?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_FILTER_CLEAR'); ?>"
						onclick="jQuery(this).closest('form').find('input').val('');">
					<?php echo Text::_('COM_EINSATZKOMPONENTE_SEARCH_FILTER_CLEAR'); ?>
				</button>
			</div>
		</div>
	</div>
	<!-- Filters div -->
	<div class="js-stools-container-filters hidden-phone clearfix" style="">
		<?php // Load the form filters ?>
		<?php if ($filters) : ?>
			<?php foreach ($filters as $fieldName => $field) : ?>
				<?php if ($fieldName != 'filter_search') : ?>
					<div class="js-stools-field-filter">
						<?php echo $field->input; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>