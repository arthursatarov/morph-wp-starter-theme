'use strict';

/*==================================================================================
  Table of Contents:
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  1.0. SETTINGS
    1.1. IMPORTS
    1.2. PATHS
    1.3. HELPERS
  2.0. TASKS
    2.1. SCRIPTS
    2.2. STYLES
    2.3. FONTS
    2.4. IMAGES
    2.5. SERVER & WATCHERS
    2.6. CLEAN
  3.0. SERIES & EXPORTS
==================================================================================*/

/*==================================================================================
  1.0. SETTINGS
==================================================================================*/

/* 1.1. IMPORTS
/––––––––––––––––––––––––*/

// core
import gulp from 'gulp';
const { src, dest, watch, series, parallel } = gulp;
import path from 'path';

// styles
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import postcss from 'gulp-postcss';
import sortMediaQueries from 'postcss-sort-media-queries';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);

// JavaScript
import esbuild from 'gulp-esbuild';

// utilities
import browserSync from 'browser-sync';
import { deleteAsync } from 'del';
import newer from 'gulp-newer';
import notify from 'gulp-notify';
import plumber from 'gulp-plumber';
import sourcemaps from 'gulp-sourcemaps';
import noop from 'gulp-noop';

/* 1.2. PATHS
/––––––––––––––––––––––––*/
const srcDir = './src';
const buildDir = './assets';

const paths = {
	src: {
		styles: path.join(srcDir, 'styles/*.scss'),
		scripts: path.join(srcDir, 'scripts/*.js'),
		fonts: path.join(srcDir, 'fonts/**/*.{woff,woff2}'),
		images: path.join(srcDir, 'images/**/*.{jpg,png,svg,gif,webp}'),
	},
	build: {
		styles: path.join(buildDir, 'styles/'),
		scripts: path.join(buildDir, 'scripts/'),
		fonts: path.join(buildDir, 'fonts/'),
		images: path.join(buildDir, 'images/'),
	},
	watch: {
		php: '**/*.php',
		styles: path.join(srcDir, 'styles/**/*.scss'),
		scripts: path.join(srcDir, 'scripts/**/*.js'),
		images: path.join(srcDir, 'images/**/*.{jpg,png,svg,gif,webp}'),
		fonts: path.join(srcDir, 'fonts/**/*.{woff,woff2}'),
	},
};

/* 1.3. HELPERS
/––––––––––––––––––––––––*/

// env flag
const isProd = process.env.NODE_ENV === 'production';

// error handler
const onError = function (err) {
	notify.onError({
		title: 'Gulp Error',
		message: '\n\n❌  <%= error.message %>\n',
		sound: 'Funk',
	})(err);

	this.emit('end');
};

/*==================================================================================
  2.0. TASKS
==================================================================================*/

/* 2.1. SCRIPTS
/––––––––––––––––––––––––*/
function scripts() {
	return src(paths.src.scripts)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(esbuild({
			target: 'es2020',
			bundle: true,
			write: false,
			minify: isProd,
			sourcemap: isProd ? false : 'inline',
		}))
		.pipe(dest(paths.build.scripts))
		.pipe(browserSync.stream());
}

/* 2.2. STYLES
/––––––––––––––––––––––––*/
function styles() {
	return src(paths.src.styles)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(!isProd ? sourcemaps.init() : noop())
		.pipe(sass())
		.pipe(postcss([
			sortMediaQueries,
			autoprefixer,
			...(isProd ? [cssnano] : []),
		]))
		.pipe(!isProd ? sourcemaps.write('.') : noop())
		.pipe(dest(paths.build.styles))
		.pipe(browserSync.stream());
}

/* 2.3. FONTS
/––––––––––––––––––––––––*/
function copyFonts() {
	return src(paths.src.fonts)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(newer(paths.build.fonts))
		.pipe(dest(paths.build.fonts))
		.pipe(browserSync.stream());
}

/* 2.4. IMAGES
/––––––––––––––––––––––––*/
function copyImages() {
	return src(paths.src.images, { encoding: false })
		.pipe(plumber({ errorHandler: onError }))
		.pipe(newer(paths.build.images))
		.pipe(dest(paths.build.images))
		.pipe(browserSync.stream());
}

/* 2.5. SERVER & WATCHERS
/––––––––––––––––––––––––*/
function serve() {
	browserSync.init({
		ui: false,
		proxy: process.env.BS_PROXY || 'localhost:8000',
		port: 3000,
		open: false,
	});

	watch(paths.watch.php).on('change', browserSync.reload);
	watch(paths.watch.scripts, scripts);
	watch(paths.watch.styles, styles);
	watch(paths.watch.fonts, copyFonts);
	watch(paths.watch.images, copyImages);
}

/* 2.6. CLEAN
/––––––––––––––––––––––––*/
async function clean() {
	await deleteAsync([buildDir]);
}

/*==================================================================================
  3.0. SERIES & EXPORTS
==================================================================================*/
export const dev = series(
	clean,
	parallel(scripts, styles, copyFonts, copyImages),
	serve
);

export const build = series(
	clean,
	parallel(scripts, styles, copyFonts, copyImages)
);

export default dev;
