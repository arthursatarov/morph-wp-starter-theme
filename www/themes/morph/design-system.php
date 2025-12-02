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
				<button class="btn btn--icon" data-tooltip-target="tooltip-1" aria-label="Add file">
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
				<button class="btn" data-dropdown-target="dropdown-1">
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
		<h3>Modal / Drawer</h3>
		<div class="cluster">
			<button class="btn" data-modal-target="modal-1" aria-haspopup="dialog">
				<span class="btn__label">Open Modal</span>
			</button>
			<button class="btn" data-drawer-target="drawer-1" aria-label="Open Drawer" aria-expanded="false"
				aria-controls="drawer-1">
				<span class="btn__label">Open Drawer</span>
			</button>
		</div>
	</div>
	<div id="modal-1" class="modal" data-modal-state="hidden" data-modal-backdrop="static">
		<div class="modal__backdrop"></div>
		<div class="modal__wrapper" style="padding: 1.5rem;">
			<button class="modal__close btn btn--icon btn--ghost" data-modal-hide="modal-1">
				<?php morph_print_sprite_icon( [
					'icon' => 'dismiss',
					'class' => 'btn__icon'
				] ); ?>
			</button>
			<div class="stack" style="--stack-space: 1.5rem;">
				<h3>Контактная форма</h3>
				<form class="form stack" novalidate>
					<div class="form-control">
						<label for="name" class="form-control__label">
							Имя <span class="form-control__required" aria-label="обязательное поле">*</span>
						</label>
						<div class="input-text">
							<input type="text" id="name" name="name" class="input-text__input" required aria-required="true"
								aria-describedby="name-error name-hint" autocomplete="name">
						</div>
						<span id="name-hint" class="form-control__hint">Введите ваше полное имя</span>
						<!-- <span id="name-error" class="form-control__validation" role="alert" aria-live="polite"></span> -->
					</div>
					<div class="form-control">
						<label for="email" class="form-control__label">
							Email <span class="form-control__required" aria-label="обязательное поле">*</span>
						</label>
						<div class="input-text">
							<input type="email" id="email" name="email" class="input-text__input" required aria-required="true"
								aria-describedby="email-error email-hint" aria-invalid="false" autocomplete="email">
						</div>
						<span id="email-hint" class="form-control__hint">Мы никогда не передадим ваш email третьим лицам</span>
						<!-- <span id="email-error" class="form-control__validation" role="alert" aria-live="polite"></span> -->
					</div>
					<fieldset class="form-control">
						<legend class="form-control__label">
							Предпочитаемый способ связи <span class="form-control__required" aria-label="обязательное поле">*</span>
						</legend>
						<span class="form-control__hint">Можно выбрать один</span>
						<div class="form-control__list">
							<div class="radio">
								<input type="radio" id="contact-email" name="contact-method" value="email" class="radio__input" checked>
								<span class="radio__box"></span>
								<label for="contact-email" class="radio__label">Email</label>
							</div>
							<div class="radio">
								<input type="radio" id="contact-phone" name="contact-method" value="phone" class="radio__input">
								<span class="radio__box"></span>
								<label for="contact-phone" class="radio__label">Телефон</label>
							</div>
						</div>
					</fieldset>
					<div class="form-control">
						<label for="message" class="form-control__label">
							Сообщение <span class="form-control__required" aria-label="обязательное поле">*</span>
						</label>
						<textarea id="message" name="message" class="textarea" rows="5" required aria-required="true"
							aria-describedby="message-error message-hint" maxlength="500"></textarea>
						<span id="message-hint" class="form-control__hint">
							Максимум 500 символов. <span class="char-count" aria-live="polite">Осталось: 500</span>
						</span>
						<span id="message-error" class="form-control__validation" role="alert" aria-live="polite"></span>
					</div>
					<div class="form-control">
						<div class="checkbox">
							<input type="checkbox" id="agree" name="agree" class="checkbox__input" required aria-required="true"
								aria-describedby="agree-error">
							<span class="checkbox__box">
								<?php morph_print_sprite_icon( [
									'icon' => 'add',
									'class' => 'checkbox__icon'
								] ); ?>
							</span>
							<label class="checkbox__label" for="agree">
								Я согласен с <a href="/privacy">политикой конфиденциальности</a>
							</label>
						</div>
						<span id="agree-error" class="form-control__validation" role="alert" aria-live="polite"></span>
					</div>
					<div class="form__actions">
						<button type="submit" class="btn btn--primary">
							Отправить
							<span class="visually-hidden" aria-live="polite" aria-atomic="true"></span>
						</button>
						<button type="reset" class="btn btn--secondary">
							Очистить
						</button>
					</div>
					<div id="form-status" class="form-status" role="status" aria-live="polite" aria-atomic="true"></div>
				</form>
			</div>
		</div>
	</div>
	<div id="drawer-1" class="drawer">
		<div class="drawer__backdrop"></div>
		<div class="drawer__wrapper">
			<button class="modal__close btn btn--icon btn--ghost" data-drawer-hide="drawer-1" aria-label="Close Drawer">
				<?php morph_print_sprite_icon( [
					'icon' => 'dismiss',
					'class' => 'btn__icon'
				] ); ?>
			</button>
			<div class="stack">
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
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae
						recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
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
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae
						recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
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
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae
						recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
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
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita, numquam quae minima beatae molestiae
						recusandae cupiditate ea tempore a nulla sequi ex delectus dolorem neque?</p>
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
				<button class="tabs__trigger" role="tab" aria-selected="true" aria-controls="tabs-panel-1" id="tabs-tab-1"
					data-tabs-trigger>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Profile</span>
				</button>
				<button class="tabs__trigger" role="tab" aria-selected="false" aria-controls="tabs-panel-2" id="tabs-tab-2"
					data-tabs-trigger>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Dashboard</span>
				</button>
				<button class="tabs__trigger" role="tab" aria-selected="false" aria-controls="tabs-panel-3" id="tabs-tab-3"
					data-tabs-trigger>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Settings</span>
				</button>
				<button class="tabs__trigger" role="tab" aria-selected="false" aria-controls="tabs-panel-3" id="tabs-tab-4"
					data-tabs-trigger disabled>
					<?php morph_print_sprite_icon( [
						'icon' => 'globe',
						'class' => 'tabs__trigger-icon'
					] ); ?>
					<span class="tabs__trigger-label">Overview</span>
				</button>
			</div>
			<div class="tabs__panels">
				<div class="tabs__panel" role="tabpanel" id="tabs-panel-1" aria-labelledby="tabs-tab-1" data-tabs-panel>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam saepe esse veniam in omnis, laudantium
						voluptatem vero. Assumenda, qui cumque quisquam totam debitis itaque at, quam sit quia animi sint?</p>
				</div>
				<div class="tabs__panel" role="tabpanel" id="tabs-panel-2" aria-labelledby="tabs-tab-2" hidden data-tabs-panel>
					<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio magnam necessitatibus ducimus,
						voluptates neque ullam nemo. Rerum accusamus consectetur recusandae in necessitatibus! Ratione, ducimus
						sit?
					</p>
				</div>
				<div class="tabs__panel" role="tabpanel" id="tabs-panel-3" aria-labelledby="tabs-tab-3" hidden data-tabs-panel>
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum dolores quisquam velit sint perferendis
						exercitationem, neque alias itaque consequuntur non?</p>
				</div>
				<div class="tabs__panel" role="tabpanel" id="tabs-panel-4" aria-labelledby="tabs-tab-4" hidden data-tabs-panel>
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum dolores quisquam velit sint perferendis
						exercitationem, neque alias itaque consequuntur non?</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrapper region">
	<div class="stack" style="--stack-space: 2rem;">
		<article class="prose">
			<h1>Современные подходы к веб-разработке</h1>

			<p>Веб-разработка прошла долгий путь от простых статических страниц до сложных интерактивных приложений. В этой
				статье мы рассмотрим ключевые принципы и практики, которые помогут создавать качественные и доступные
				веб-сайты.
			</p>

			<h2>Основы типографики в вебе</h2>

			<p>Типографика — это искусство и техника оформления текста. Хорошая типографика делает контент более читаемым и
				приятным для восприятия. <strong>Правильный выбор шрифтов, размеров и отступов</strong> критически важен для
				пользовательского опыта.</p>

			<p>Существует несколько ключевых аспектов, которые необходимо учитывать при работе с типографикой:</p>

			<ul>
				<li>Размер шрифта должен быть достаточно большим для комфортного чтения (минимум 16px для основного текста)
				</li>
				<li>Межстрочный интервал влияет на удобство чтения длинных текстов</li>
				<li>Оптимальная длина строки составляет 60-75 символов</li>
				<li>Контрастность текста и фона должна соответствовать стандартам <em>WCAG 2.1</em></li>
			</ul>

			<h3>Выбор шрифтов</h3>

			<p>При выборе шрифтов для веб-проекта следует учитывать не только эстетику, но и практичность. Веб-безопасные
				шрифты гарантируют корректное отображение на всех устройствах, в то время как кастомные шрифты позволяют
				создать
				уникальный визуальный стиль.</p>

			<blockquote>
				<p>Типографика — это то, что стоит между читателем и информацией. Хорошая типографика незаметна, плохая —
					раздражает.</p>
				<cite>Роберт Брингхерст</cite>
			</blockquote>

			<h3>Иерархия заголовков</h3>

			<p>Правильная иерархия заголовков помогает структурировать контент и улучшает как визуальное восприятие, так и
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

			<p>Цвет играет важную роль в веб-дизайне, но его использование должно быть продуманным. Недостаточный контраст
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
				традиционно используется для ошибок, зелёный — для успешных действий, синий — для информационных сообщений.
			</p>

			<h2>Адаптивная типографика</h2>

			<p>Современные веб-сайты должны корректно отображаться на устройствах с различными размерами экранов.
				<mark>Адаптивная типографика</mark> позволяет тексту масштабироваться плавно в зависимости от ширины вьюпорта.
			</p>

			<pre><code>/* Пример использования clamp() */
.text {
	font-size: clamp(1rem, 0.95rem + 0.25vw, 1.125rem);
}</code></pre>

			<p>Функция <code>clamp()</code> принимает три параметра: минимальное значение, предпочтительное значение и
				максимальное значение. Это позволяет создавать плавно масштабируемые размеры шрифтов.</p>

			<h3>Viewport-based units</h3>

			<p>Использование единиц измерения на основе вьюпорта (<code>vw</code>, <code>vh</code>, <code>vmin</code>,
				<code>vmax</code>) даёт дополнительную гибкость, но требует осторожности, чтобы избежать слишком мелкого или
				крупного текста на экстремальных размерах экранов.
			</p>

			<hr>

			<h2>Заключение</h2>

			<p>Качественная типографика — это фундамент хорошего веб-дизайна. Она требует внимания к деталям, понимания
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
				<li><a href="#">Practical Typography by Matthew Butterick</a> — исчерпывающее руководство по типографике</li>
				<li><a href="#">Web Typography by Richard Rutter</a> — специализированная книга о типографике в вебе</li>
				<li><a href="#">Type Scale</a> — инструмент для создания типографических систем</li>
				<li><a href="#">WCAG Guidelines</a> — официальная документация по доступности</li>
			</ul>
		</article>
	</div>
</div>

<?php
get_footer();

