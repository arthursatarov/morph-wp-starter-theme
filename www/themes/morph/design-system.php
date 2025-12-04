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

<!-- Accordion -->
<section class="wrapper region" aria-describedby="#accordion-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="accordion-section">Accordion</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			An accordion allows users to toggle the display of content by expanding or collapsing sections.
		</p>
		<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
			<!-- Single -->
			<div class="stack" style="inline-size: 32rem;">
				<h3>Single</h3>
				<p>Only one panel can be expanded.</p>
				<hr>
				<div class="accordion" data-accordion-type="single">
					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger" aria-expanded="true">
								<span>Accordion Header 1</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>

					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger">
								<span>Accordion Header 2</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>

					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger">
								<span>Accordion Header 3</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Multiple -->
			<div class="stack" style="inline-size: 32rem;">
				<h3>Multiple</h3>
				<p>An accordion supports multiple panels expanded simultaneously.</p>
				<hr>
				<div class="accordion" data-accordion-type="multiple">
					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger" aria-expanded="true">
								<span>Accordion Header 1</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>

					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger" aria-expanded="true">
								<span>Accordion Header 2</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>

					<div class="accordion__item">
						<h3>
							<button class="accordion__item-trigger">
								<span>Accordion Header 3</span>
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-chevron-right-regular',
									'class' => 'accordion__item-icon'
								] ); ?>
							</button>
						</h3>
						<div class="accordion__item-content">
							<p>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, eius. Nihil exercitationem temporibus
								totam unde!
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<hr>

<!-- Dropdown/Modal/Drawer -->
<div class="wrapper region" style="padding-block-end: calc(4rem + 7.5rem)">
	<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
		<!-- Dropdown -->
		<section class="stack" aria-describedby="#dropdown-section" style="inline-size: 20rem;">
			<h2 id="dropdown-section">Dropdown</h2>
			<p>
				The dropdown component can be used to show a list of menu items when clicking on an element such as a button.
			</p>
			<hr>
			<button class="btn" data-dropdown-target="dropdown-1">
				<span class="btn__label">Dropdown</span>
				<?php morph_print_sprite_icon( [
					'icon' => 'icon-chevron-down-regular',
					'class' => 'btn__icon'
				] ); ?>
			</button>
			<div id="dropdown-1" class="dropdown" data-show>
				<div class="stack" style="--stack-space: 0.5rem; padding: 0.5rem;">
					<a href="#dropdown-section" class="link link--subtle">Menu item 1</a>
					<a href="#dropdown-section" class="link link--subtle">Menu item 2</a>
					<a href="#dropdown-section" class="link link--subtle">Menu item 3</a>
				</div>
			</div>
		</section>

		<!-- Modal -->
		<section class="stack" aria-describedby="#modal-section" style="inline-size: 20rem;">
			<h2 id="modal-section">Modal</h2>
			<p>
				The modal component can be used as an interactive dialog on top of the main content area of the website.
			</p>
			<hr>
			<button class="btn" data-modal-target="modal-1">
				<span class="btn__label">Open modal</span>
			</button>

			<!-- Modal window -->
			<div id="modal-1" class="modal" data-modal-backdrop="static">
				<div class="modal__backdrop"></div>
				<div class="modal__wrapper">
					<button class="modal__close | btn btn--icon btn--ghost" data-modal-hide="modal-1" aria-label="Close modal">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-dismiss-regular',
							'class' => 'btn__icon'
						] ); ?>
					</button>
					<div class="stack" style="--stack-space: 1.5rem;">
						<h3>Terms of Service</h3>
						<hr>
						<p>
							With less than a month to go before the European Union enacts new consumer privacy laws for its
							citizens, companies around the world are updating their terms of service agreements to comply.
						</p>
						<div class="cluster">
							<button class="btn btn--primary" data-modal-hide="modal-1">
								<span class="btn__label">I accept</span>
							</button>
							<button class="btn" data-modal-hide="modal-1">
								<span class="btn__label">Decline</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Drawer -->
		<section class="stack" aria-describedby="drawer-section" style="inline-size: 20rem;">
			<h2 id="drawer-section">Drawer</h2>
			<p>
				Use the Drawer component (or “off-canvas”) to show a fixed element relative to the document page from any side.
			</p>
			<hr>
			<button class="btn" data-drawer-target="drawer-1">
				<span class="btn__label">Open drawer</span>
			</button>

			<!-- Drawer window -->
			<div id="drawer-1" class="drawer" style="--stack-item-space: 0;">
				<div class="drawer__backdrop"></div>
				<div class="drawer__wrapper">
					<button class="drawer__close | btn btn--icon btn--ghost" data-drawer-hide="drawer-1"
						aria-label="Close drawer">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-dismiss-regular',
							'class' => 'btn__icon'
						] ); ?>
					</button>
					<div class="stack" style="--stack-item-space: 1.5rem;">
						<h3>Terms of Service</h3>
						<hr>
						<p>
							With less than a month to go before the European Union enacts new consumer privacy laws for its
							citizens, companies around the world are updating their terms of service agreements to comply.
						</p>
						<div class="cluster">
							<button class="btn btn--primary" data-drawer-hide="drawer-1">
								<span class="btn__label">I accept</span>
							</button>
							<button class="btn" data-drawer-hide="drawer-1">
								<span class="btn__label">Decline</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<hr>

<!-- Tag -->
<section class="wrapper region" aria-describedby="#tag-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="tag-section">Tag</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			A tag labels UI objects for quick recognition and navigation.
		</p>
		<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
			<!-- Simple tag -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Styles</h3>
				<hr>
				<a class="tag">
					<span class="tag__label">Default</span>
				</a>
				<a class="tag" aria-disabled="true">
					<span class="tag__label">Disabled</span>
				</a>
			</div>
			<div class="stack" style="inline-size: 20rem;">
				<h3>With icon</h3>
				<hr>
				<a class="tag">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-clock-regular',
						'class' => 'tag__icon'
					] ); ?>
					<span class="tag__label">2 minutes ago</span>
				</a>
				<a class="tag" aria-disabled="true">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-clock-regular',
						'class' => 'tag__icon'
					] ); ?>
					<span class="tag__label">2 minutes ago</span>
				</a>
			</div>
		</div>
	</div>
</section>

<hr>

<!-- Button -->
<section class="wrapper region" aria-describedby="#button-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="button-section">Button</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">Button is used to initiate actions on a page or form.
		</p>
		<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
			<!-- Simple button -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Styles</h3>
				<hr>
				<button class="btn">
					<span class="btn__label">Default</span>
				</button>
				<button class="btn btn--primary">
					<span class="btn__label">Primary</span>
				</button>
				<button class="btn btn--ghost">
					<span class="btn__label">Ghost</span>
				</button>
				<button class="btn" disabled>
					<span class="btn__label">Disabled</span>
				</button>
			</div>

			<!-- With Icon -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>With icon</h3>
				<hr>
				<button class="btn">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
					<span class="btn__label">Default</span>
				</button>
				<button class="btn btn--primary">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
					<span class="btn__label">Primary</span>
				</button>
				<button class="btn btn--ghost">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
					<span class="btn__label">Ghost</span>
				</button>
				<button class="btn" disabled>
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
					<span class="btn__label">Disabled</span>
				</button>
			</div>

			<!-- Icon only -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Icon only</h3>
				<hr>
				<button class="btn btn--icon" data-tooltip-target="delete-1" data-tooltip-placement="right"
					aria-label="Delete file">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
				</button>
				<button class="btn btn--icon btn--primary" data-tooltip-target="delete-2" data-tooltip-placement="right"
					aria-label="Delete file">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
				</button>
				<button class="btn btn--icon btn--ghost" data-tooltip-target="delete-3" data-tooltip-placement="right"
					aria-label="Delete file">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
				</button>
				<button class="btn btn--icon" aria-label="Delete file" disabled>
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-delete-regular',
						'class' => 'btn__icon'
					] ); ?>
				</button>

				<!-- Tooltips -->
				<?php morph_print_tooltip( 'delete-1', 'Delete file' ); ?>
				<?php morph_print_tooltip( 'delete-2', 'Delete file' ); ?>
				<?php morph_print_tooltip( 'delete-3', 'Delete file' ); ?>
			</div>
		</div>
	</div>
</section>

<hr>

<!-- Input -->
<section class="wrapper region" aria-describedby="#input-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="input-section">Input</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">Text input is used to set a value that is a single line
			of text.</p>
		<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
			<!-- Stories -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Stories</h3>
				<hr>
				<!-- Default input -->
				<div class="form-control">
					<label class="form-control__label">Default input</label>
					<div class="input-text">
						<input type="text" class="input-text__input" placeholder="Placeholder text">
					</div>
				</div>

				<!-- With leading icon -->
				<div class="form-control">
					<label class="form-control__label">Full name</label>
					<div class="input-text">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-person-regular',
							'class' => 'input-text__icon'
						] ); ?>
						<input type="text" class="input-text__input" placeholder="John Smith">
					</div>
					<span class="form-control__hint">An input with a decorative leading icon.</span>
				</div>

				<!-- With trailing icon -->
				<div class="form-control">
					<label class="form-control__label">Full name</label>
					<div class="input-text">
						<input type="text" class="input-text__input" placeholder="John Smith">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-person-regular',
							'class' => 'input-text__icon'
						] ); ?>
					</div>
					<span class="form-control__hint">An input with a decorative trailing icon.</span>
				</div>

				<!-- Disabled -->
				<div class="form-control">
					<label class="form-control__label">Disabled input</label>
					<div class="input-text">
						<input type="text" class="input-text__input" placeholder="Placeholder text" disabled>
					</div>
				</div>
			</div>

			<!-- Interactive Actions -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Interactive actions</h3>
				<hr>
				<!-- Clear input -->
				<div class="form-control">
					<label class="form-control__label">Clear input</label>
					<div class="input-text">
						<input type="text" class="input-text__input" value="Some text" placeholder="Type something">
						<button type="button" class="input-text__action" data-input-action="clear" hidden>
							<?php morph_print_sprite_icon( [
								'icon' => 'icon-dismiss-circle-regular',
								'class' => 'input-text__action-icon'
							] ); ?>
						</button>
					</div>
				</div>

				<!-- Toggle password -->
				<div class="form-control">
					<label class="form-control__label">Password toggle</label>
					<div class="input-text">
						<input type="password" class="input-text__input" value="password">
						<button type="button" class="input-text__action" data-input-action="toggle">
							<?php morph_print_sprite_icon( [
								'icon' => 'icon-eye-regular',
								'class' => 'input-text__action-icon'
							] ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Form control -->
<section class="wrapper region" aria-describedby="#form-control-section">
	<div class="stack" style="--stack-space: 2rem;">
		<h2 id="form-control-section">Form control</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">FormControl displays a labelled input and optionally
			associated validation text and/or hint text.</p>

		<div class="cluster" style="--cluster-gap: 4rem; --cluster-align: start;">
			<!-- Stories -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Stories</h3>
				<hr>
				<!-- Default -->
				<div class="form-control">
					<label for="input-default" class="form-control__label">Example field</label>
					<div class="input-text">
						<input type="text" id="input-default" name="input-default" class="input-text__input">
					</div>
					<span class="form-control__hint">This is example hint</span>
				</div>
				<!-- Required -->
				<div class="form-control" data-required>
					<label for="input-required" class="form-control__label">Required field</label>
					<div class="input-text">
						<input type="text" id="input-required" name="input-required" class="input-text__input">
					</div>
					<span class="form-control__hint">This is required filed</span>
				</div>
			</div>

			<!-- Validation -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Validation</h3>
				<hr>
				<!-- Success -->
				<div class="form-control">
					<label for="input-success" class="form-control__label">Success state</label>
					<div class="input-text" data-validation-status="success">
						<input type="text" id="input-success" name="input-success" class="input-text__input">
					</div>
					<span class="form-control__validation" data-validation-status="success">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-checkmark-circle-filled',
							'class' => 'form-control__validation-icon'
						] ); ?>
						<span>This is success message</span>
					</span>
				</div>
				<!-- Warning -->
				<div class="form-control">
					<label for="input-warning" class="form-control__label">Warning state</label>
					<div class="input-text" data-validation-status="warning">
						<input type="text" id="input-warning" name="input-warning" class="input-text__input">
					</div>
					<span class="form-control__validation" data-validation-status="warning">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-warning-filled',
							'class' => 'form-control__validation-icon'
						] ); ?>
						<span>This is warning message</span>
					</span>
				</div>
				<!-- Error -->
				<div class="form-control">
					<label for="input-error" class="form-control__label">Error state</label>
					<div class="input-text" data-validation-status="error">
						<input type="text" id="input-error" name="input-error" class="input-text__input">
					</div>
					<span class="form-control__validation" data-validation-status="error">
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-error-circle-filled',
							'class' => 'form-control__validation-icon'
						] ); ?>
						<span>This is error message</span>
					</span>
				</div>
			</div>

			<!-- Components -->
			<div class="stack" style="inline-size: 20rem;">
				<h3>Components</h3>
				<hr>
				<!-- Input -->
				<div class="form-control">
					<label for="input-input" class="form-control__label">Input</label>
					<div class="input-text">
						<input type="text" id="input-input" name="input-input" class="input-text__input">
					</div>
				</div>
				<!-- Textarea -->
				<div class="form-control">
					<label for="textarea" class="form-control__label">Textarea</label>
					<textarea id="textarea" name="message" class="textarea" rows="2"></textarea>
				</div>
				<!-- Select -->
				<div class="form-control">
					<label for="select" class="form-control__label">Select</label>
					<div class="select">
						<select id="select" name="select" class="select__input">
							<option value="">Choose option</option>
							<option value="1">Option 1</option>
							<option value="2">Option 2</option>
							<option value="3">Option 3</option>
							<option value="4">Option 4</option>
						</select>
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-chevron-down-regular',
							'class' => 'select__icon',
							'size' => 'md'
						] ); ?>
					</div>
				</div>
				<!-- Radio group -->
				<fieldset class="form-control">
					<legend class="form-control__label">Radio group</legend>
					<span class="form-control__hint">You can choose one option</span>
					<div class="form-control__list">
						<div class="radio">
							<input type="radio" id="radio-1" name="radio-group" value="radio-1" class="radio__input" checked>
							<span class="radio__box"></span>
							<label for="radio-1" class="radio__label">Option 1</label>
						</div>
						<div class="radio">
							<input type="radio" id="radio-2" name="radio-group" value="radio-2" class="radio__input">
							<span class="radio__box"></span>
							<label for="radio-2" class="radio__label">Option 2</label>
						</div>
					</div>
				</fieldset>
				<!-- Checkbox group -->
				<fieldset class="form-control">
					<legend class="form-control__label">Checkbox group</legend>
					<span class="form-control__hint">You can choose multiple options</span>
					<div class="form-control__list">
						<div class="checkbox">
							<input type="checkbox" id="checkbox-1" name="checkbox-group" value="checkbox-1" class="checkbox__input"
								checked>
							<span class="checkbox__box">
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-checkmark-filled',
									'class' => 'checkbox__icon'
								] ); ?>
							</span>
							<label for="checkbox-1" class="checkbox__label">Option 1</label>
						</div>
						<div class="checkbox">
							<input type="checkbox" id="checkbox-2" name="checkbox-group" value="checkbox-2" class="checkbox__input">
							<span class="checkbox__box">
								<?php morph_print_sprite_icon( [
									'icon' => 'icon-checkmark-filled',
									'class' => 'checkbox__icon'
								] ); ?>
							</span>
							<label for="checkbox-2" class="checkbox__label">Option 2</label>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</section>

<hr>

<!-- Link -->
<section class="wrapper region" aria-describedby="#input-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="input-section">Link</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			Links allow users to navigate between different locations. They can be used as standalone controls or inline with
			text.
		</p>
		<div class="cluster" style="--cluster-gap: 4rem;">
			<a href="" class="link">Default link</a>
			<a href="" class="link link--subtle">Subtle link</a>
			<a href="" class="link link--inline">Inline link</a>
			<div style="padding: 1rem; background-color: var(--clr-background-accent-1-rest); border-radius: 0.25rem;">
				<a href="" class="link link--on-emphasis">Link on emphasis</a>
			</div>
		</div>
	</div>
</section>

<hr>

<!-- Table -->
<section class="wrapper region" aria-describedby="#table-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="table-section">Table</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			Use the table component to show text, images, links, and other elements inside a structured set of data made up of
			rows and columns of table cells
		</p>
		<table>
			<thead>
				<tr>
					<th>Уровень</th>
					<th>Обычный текст</th>
					<th>Крупный текст</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>AA</td>
					<td>4.5:1</td>
					<td>3:1</td>
				</tr>
				<tr>
					<td>AAA</td>
					<td>7:1</td>
					<td>4.5:1</td>
				</tr>
			</tbody>
		</table>

	</div>
</section>

<hr>

<!-- Tabs -->
<section class="wrapper region" aria-describedby="#tabs-section">
	<div class="stack" style="--stack-space: 2rem">
		<h2 id="tabs-section">Tabs</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			Use these responsive tabs components to create a secondary navigational hierarchy for your website or toggle
			content inside a container
		</p>

		<div class="tabs" style="inline-size: 40rem;">
			<div class="tabs__list">
				<button class="tabs__trigger">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-person-regular',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">User</span>
				</button>
				<button class="tabs__trigger">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-document-regular',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Documents</span>
				</button>
				<button class="tabs__trigger">
					<?php morph_print_sprite_icon( [
						'icon' => 'icon-info-regular',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Info</span>
				</button>
			</div>
			<div class="tabs__panels">
				<div class="tabs__panel">
					<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi ut, facilis, maxime nesciunt quibusdam
						adipisci ipsam molestias numquam dolorem veniam sequi quo reiciendis. Nulla, dolores.</p>
				</div>
				<lore class="tabs__panel">
					<p>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, repellendus nostrum. Natus praesentium in
						rerum?
					</p>
				</lore>
				<div class="tabs__panel">
					<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi ut, facilis, maxime nesciunt quibusdam
						adipisci ipsam molestias numquam dolorem veniam sequi quo reiciendis. Nulla, dolores.</p>
				</div>
			</div>
		</div>

	</div>
</section>

<hr>

<!-- Prose -->
<section class="wrapper region" aria-describedby="#prose-section">
	<div class="stack" style="--stack-space: 2rem;">
		<h2 id="prose-section">Prose</h2>
		<p style="--stack-item-space: 1rem; max-inline-size: 55ch;">
			An accordion allows users to toggle the display of content by expanding or collapsing sections.
		</p>
		<div class="accordion" data-accordion-type="single" style="max-inline-size: 80ch;">
			<div class="accordion__item">
				<h3>
					<button class="accordion__item-trigger">
						<span>Expand article</span>
						<?php morph_print_sprite_icon( [
							'icon' => 'icon-chevron-right-regular',
							'class' => 'accordion__item-icon'
						] ); ?>
					</button>
				</h3>
				<div class="accordion__item-content">
					<div class="stack" style="--stack-space: 2rem;">
						<hr>
						<article class="prose">
							<h1>Современные подходы к веб-разработке</h1>
							<p>Веб-разработка прошла долгий путь от простых статических страниц до сложных интерактивных приложений. В
								этой
								статье мы рассмотрим ключевые принципы и практики, которые помогут создавать качественные и доступные
								веб-сайты.
							</p>
							<h2>Основы типографики в вебе</h2>
							<p>Типографика — это искусство и техника оформления текста. Хорошая типографика делает контент более
								читаемым и
								приятным для восприятия. <strong>Правильный выбор шрифтов, размеров и отступов</strong> критически важен
								для
								пользовательского опыта.</p>
							<p>Существует несколько ключевых аспектов, которые необходимо учитывать при работе с типографикой:</p>
							<ul>
								<li>Размер шрифта должен быть достаточно большим для комфортного чтения (минимум 16px для основного
									текста)
								</li>
								<li>Межстрочный интервал влияет на удобство чтения длинных текстов</li>
								<li>Оптимальная длина строки составляет 60-75 символов</li>
								<li>Контрастность текста и фона должна соответствовать стандартам <em>WCAG 2.1</em></li>
							</ul>
							<h3>Выбор шрифтов</h3>
							<p>При выборе шрифтов для веб-проекта следует учитывать не только эстетику, но и практичность.
								Веб-безопасные
								шрифты гарантируют корректное отображение на всех устройствах, в то время как кастомные шрифты позволяют
								создать
								уникальный визуальный стиль.</p>
							<blockquote>
								<p>Типографика — это то, что стоит между читателем и информацией. Хорошая типографика незаметна, плохая
									—
									раздражает.</p>
								<cite>Роберт Брингхерст</cite>
							</blockquote>
							<h3>Иерархия заголовков</h3>
							<p>Правильная иерархия заголовков помогает структурировать контент и улучшает как визуальное восприятие,
								так и
								доступность для скринридеров.</p>
							<h4>Практические рекомендации</h4>
							<p>Используйте заголовки последовательно, не пропуская уровни. Например, после <code>h2</code> должен идти
								<code>h3</code>, а не <code>h4</code>. Это важно для семантической структуры документа.
							</p>
							<ol>
								<li>Всегда начинайте страницу с <code>h1</code></li>
								<li>Используйте только один <code>h1</code> на странице</li>
								<li>Не выбирайте заголовки по внешнему виду — используйте CSS для стилизации</li>
								<li>Каждый заголовок должен быть осмысленным и описательным</li>
							</ol>
							<h2>Работа с цветом и контрастностью</h2>
							<p>Цвет играет важную роль в веб-дизайне, но его использование должно быть продуманным. Недостаточный
								контраст
								между текстом и фоном может сделать контент нечитаемым для людей с нарушениями зрения.</p>
							<h3>Стандарты WCAG</h3>
							<p>Web Content Accessibility Guidelines (WCAG) устанавливают минимальные требования к контрастности:</p>
							<table>
								<thead>
									<tr>
										<th>Уровень</th>
										<th>Обычный текст</th>
										<th>Крупный текст</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>AA</td>
										<td>4.5:1</td>
										<td>3:1</td>
									</tr>
									<tr>
										<td>AAA</td>
										<td>7:1</td>
										<td>4.5:1</td>
									</tr>
								</tbody>
							</table>
							<h3>Выбор цветовой палитры</h3>
							<p>При создании цветовой схемы важно учитывать не только эстетические предпочтения, но и психологическое
								воздействие цветов, а также их влияние на читаемость текста.</p>
							<h4>Основные принципы</h4>
							<p>Выбирайте цвета осознанно. Каждый цвет должен иметь свою функцию в дизайн-системе. Например, красный
								традиционно используется для ошибок, зелёный — для успешных действий, синий — для информационных
								сообщений.
							</p>
							<h2>Адаптивная типографика</h2>
							<p>Современные веб-сайты должны корректно отображаться на устройствах с различными размерами экранов.
								<mark>Адаптивная типографика</mark> позволяет тексту масштабироваться плавно в зависимости от ширины
								вьюпорта.
							</p>
							<pre><code>/* Пример использования clamp() */ <br>.text {<br>  font-size: clam (1rem, 0.95rem + 0.25vw, 1.125rem);<br>}</code></pre>
							<p>Функция <code>clamp()</code> принимает три параметра: минимальное значение, предпочтительное значение и
								максимальное значение. Это позволяет создавать плавно масштабируемые размеры шрифтов.</p>
							<h3>Viewport-based units</h3>
							<p>Использование единиц измерения на основе вьюпорта (<code>vw</code>, <code>vh</code>, <code>vmin</code>,
								<code>vmax</code>) даёт дополнительную гибкость, но требует осторожности, чтобы избежать слишком мелкого
								или
								крупного текста на экстремальных размерах экранов.
							</p>
							<hr>
							<h2>Заключение</h2>
							<p>Качественная типографика — это фундамент хорошего веб-дизайна. Она требует внимания к деталям,
								понимания
								принципов читаемости и доступности, а также технических знаний для корректной реализации.</p>
							<p>Инвестируя время в правильную настройку типографики, вы создаёте основу для приятного и эффективного
								взаимодействия пользователей с вашим контентом. Помните: <strong>хорошая типографика незаметна, но её
									отсутствие
									всегда бросается в глаза</strong>.</p>
							<figure>
								<img src="https://placehold.co/800x400/" alt="Пример типографики" width="800" height="400">
								<figcaption>Визуальная иерархия создаётся через размер, вес и цвет шрифта</figcaption>
							</figure>
							<h3>Дополнительные ресурсы</h3>
							<p>Для углублённого изучения темы рекомендуем следующие ресурсы:</p>
							<ul>
								<li><a href="#">Practical Typography by Matthew Butterick</a> — исчерпывающее руководство по типографике
								</li>
								<li><a href="#">Web Typography by Richard Rutter</a> — специализированная книга о типографике в вебе
								</li>
								<li><a href="#">Type Scale</a> — инструмент для создания типографических систем</li>
								<li><a href="#">WCAG Guidelines</a> — официальная документация по доступности</li>
							</ul>
							brticle>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();

