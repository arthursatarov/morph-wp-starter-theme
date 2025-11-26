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

<?php
get_footer();

