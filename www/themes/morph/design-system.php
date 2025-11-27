<?php
/**
 * Template Name: Дизайн система
 * Template Post Type: page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MORPH
 */

get_header();
?>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<h3>Buttons / Tooltips / Dropdowns</h3>
		<div class="cluster" style="--cluster-gap: 4rem; align-items: start;">
			<div class="stack">
				<p>Button icon</p>
				<button
					class="btn btn--icon"
					data-tooltip-target="tooltip-1"
					aria-label="Add file">
					<?php morph_print_sprite_icon( [
						'icon' => 'add',
						'class' => 'btn__icon'
					] ); ?>
				</button>
				<?php morph_print_tooltip( 'tooltip-1', 'Add file' ); ?>
			</div>
			<div class="stack">
				<div class="stack">
					<p>Button</p>
					<div class="cluster">
						<button class="btn btn--primary">
							<span class="btn__label">Button</span>
						</button>
						<button class="btn">
							<span class="btn__label">Button</span>
						</button>
						<button class="btn" disabled>
							<span class="btn__label">Button</span>
						</button>
					</div>
				</div>
				<div class="stack">
					<p>Button with icon</p>
					<div class="cluster">
						<button class="btn btn--primary">
							<?php morph_print_sprite_icon( [
								'icon' => 'add',
								'class' => 'btn__icon'
							] ); ?>
							<span class="btn__label">Button</span>
						</button>
						<button class="btn">
							<?php morph_print_sprite_icon( [
								'icon' => 'add',
								'class' => 'btn__icon'
							] ); ?>
							<span class="btn__label">Button</span>
						</button>
						<button class="btn" disabled>
							<?php morph_print_sprite_icon( [
								'icon' => 'add',
								'class' => 'btn__icon'
							] ); ?>
							<span class="btn__label">Button</span>
						</button>
					</div>
				</div>
			</div>
			<div class="stack">
				<p>Dropdown</p>
				<button
					class="btn"
					data-dropdown-target="dropdown-1">
					<span class="btn__label">Dropdown</span>
					<?php morph_print_sprite_icon( [
						'icon' => 'chevron-down',
						'class' => 'btn__icon'
					] ); ?>
				</button>
				<div id="dropdown-1" class="dropdown">
					<ul role="list">
						<li>Item 1</li>
						<li>Item 2</li>
						<li>Item 3</li>
						<li>Item 4</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<h3>Tags</h3>
		<div class="cluster">
			<a class="tag tag--primary">
				<?php morph_print_sprite_icon( [
					'icon' => 'globe',
					'class' => 'tag__icon'
				] ); ?>
				<span class="tag__label">Tag</span>
			</a>
			<a class="tag">
				<?php morph_print_sprite_icon( [
					'icon' => 'globe',
					'class' => 'tag__icon'
				] ); ?>
				<span class="tag__label">Tag</span>
			</a>
		</div>
	</div>
</div>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<h3>Accordion</h3>
		<div class="accordion" data-accordion="collapse" style="max-inline-size: 40rem;">
			<div class="accordion__item">
				<h2>
					<button class="accordion__item-trigger">
						<span>Section 1</span>
						<?php morph_print_sprite_icon( [
							'icon' => 'chevron-right',
							'class' => 'accordion__item-icon'
						] ); ?>
					</button>
				</h2>
				<div class="accordion__item-content">
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
				</div>
			</div>
			<div class="accordion__item">
				<h2>
					<button class="accordion__item-trigger">
						<span>Section 2</span>
						<?php morph_print_sprite_icon( [
							'icon' => 'chevron-right',
							'class' => 'accordion__item-icon'
						] ); ?>
					</button>
				</h2>
				<div class="accordion__item-content">
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
				</div>
			</div>
			<div class="accordion__item">
				<h2>
					<button class="accordion__item-trigger">
						<span>Section 3</span>
						<?php morph_print_sprite_icon( [
							'icon' => 'chevron-right',
							'class' => 'accordion__item-icon'
						] ); ?>
					</button>
				</h2>
				<div class="accordion__item-content">
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
				</div>
			</div>
			<div class="accordion__item">
				<h2>
					<button class="accordion__item-trigger">
						<span>Section 4</span>
						<?php morph_print_sprite_icon( [
							'icon' => 'chevron-right',
							'class' => 'accordion__item-icon'
						] ); ?>
					</button>
				</h2>
				<div class="accordion__item-content">
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<h3>Tabs</h3>
		<div class="tabs" style="max-inline-size: 40rem;" data-tabs>
			<div class="tabs__list" role="tablist" aria-label="Примеры табов">
				<button
					class="tabs__trigger"
					role="tab"
					aria-selected="true"
					aria-controls="tabs-panel-1"
					id="tabs-tab-1"
					data-tabs-trigger
				>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Profile</span>
				</button>
				<button
					class="tabs__trigger"
					role="tab"
					aria-selected="false"
					aria-controls="tabs-panel-2"
					id="tabs-tab-2"
					data-tabs-trigger
				>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Dashboard</span>
				</button>
				<button
					class="tabs__trigger"
					role="tab"
					aria-selected="false"
					aria-controls="tabs-panel-3"
					id="tabs-tab-3"
					data-tabs-trigger
				>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Settings</span>
				</button>
				<button
					class="tabs__trigger"
					role="tab"
					aria-selected="false"
					aria-controls="tabs-panel-3"
					id="tabs-tab-4"
					data-tabs-trigger
					disabled
				>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Overview</span>
				</button>
			</div>
			<div class="tabs__panels">
				<div
					class="tabs__panel"
					role="tabpanel"
					id="tabs-panel-1"
					aria-labelledby="tabs-tab-1"
					data-tabs-panel
				>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam saepe esse veniam in omnis, laudantium voluptatem vero. Assumenda, qui cumque quisquam totam debitis itaque at, quam sit quia animi sint?</p>
				</div>

				<div
					class="tabs__panel"
					role="tabpanel"
					id="tabs-panel-2"
					aria-labelledby="tabs-tab-2"
					hidden
					data-tabs-panel
				>
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio magnam necessitatibus ducimus, voluptates neque ullam nemo. Rerum accusamus consectetur recusandae in necessitatibus! Ratione, ducimus sit?</p>
				</div>

				<div
					class="tabs__panel"
					role="tabpanel"
					id="tabs-panel-3"
					aria-labelledby="tabs-tab-3"
					hidden
					data-tabs-panel
				>
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum dolores quisquam velit sint perferendis exercitationem, neque alias itaque consequuntur non?</p>
				</div>
				<div
					class="tabs__panel"
					role="tabpanel"
					id="tabs-panel-4"
					aria-labelledby="tabs-tab-4"
					hidden
					data-tabs-panel
				>
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum dolores quisquam velit sint perferendis exercitationem, neque alias itaque consequuntur non?</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<h3>Tables</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Место</th>
					<th>Оценка</th>
					<th>Название фильма</th>
					<th>Год выхода</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>9.1</td>
					<td>Зелёная миля</td>
					<td>1999</td>
				</tr>
				<tr>
					<td>2</td>
					<td>9.1</td>
					<td>Побег из Шоушенка</td>
					<td>1994</td>
				</tr>
				<tr>
					<td>3</td>
					<td>8.6</td>
					<td>Властелин колец: Возвращение Короля</td>
					<td>2003</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php
get_footer();

