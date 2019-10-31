var gulp = require('gulp'),
	browserSync = require('browser-sync').create(),
	reload = browserSync.reload,
	autoprefixer = require('gulp-autoprefixer'),
	includeHtml = require('gulp-include-tag'),
	pug = require('pug'),
	es = require('event-stream'),
	concat = require('gulp-concat'),
	rigger = require('gulp-rigger'),
	cssminify = require('gulp-clean-css'),
	changed = require('gulp-changed'),
	imagemin = require('gulp-imagemin'),
	sass = require('gulp-sass');

var config = {
	paths: {
		css: {
			src_backend: './src/backend/style/scss/*.{sass,scss}',
			watch_backend: './src/backend/style/scss/**/*.{sass,scss}',
			build_backend: './build/backend/assets/css/',
			application_backend: "../application/backend/web/css/",

			src_frontend: './src/frontend/style/scss/*.{sass,scss}',
			watch_frontend: './src/frontend/style/scss/**/*.{sass,scss}',
			build_frontend: './build/frontend/assets/css/',
		},
		html: {
			src_backend: './src/backend/html/*.{html,htm}',
			watch_backend: './src/backend/html/**/*.{html,htm}',
			build_backend: './build/backend/',

			src_frontend: './src/frontend/html/*.{html,htm}',
			watch_frontend: './src/frontend/html/**/*.{html,htm}',
			build_frontend: './build/frontend/',

		},
		js: {
			src_backend: './src/backend/js/**/*.js',
			watch_backend: './src/backend/js/**/*.js',
			build_backend: './build/backend/assets/js/',
			application_backend: "../application/backend/web/js/",

			src_frontend: './src/frontend/js/**/*.js',
			watch_frontend: './src/frontend/js/**/*.js',
			build_frontend: './build/frontend/assets/js/',

		},
		image: {
			src_backend: './src/backend/js/**/*.{png,webp,jpg,jpeg,svg,gif}',
			watch_backend: './src/backend/js/**/*.{png,webp,jpg,jpeg,svg,gif}',
			build_backend: './build/backend/assets/js/',
			application_backend: '../application/backend/web/js/',

			src_frontend: './src/frontend/images/**/*.{png,jpg,jpeg,svg,gif}',
			watch_frontend: './src/frontend/images/**/*.{png,jpg,jpeg,svg,gif}',
			build_frontend: './build/frontend/assets/images/',
		},
		copy: {
			src_backend: './src/backend/js/**/*.js',
			watch_backend: './src/backend/js/**/*.js',
			build_backend: './build/backend/assets/js/',
			application_backend: "../application/backend/web/js/",

			src_frontend: './src/frontend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			watch_frontend: './src/frontend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			build_frontend: './build/frontend/assets/images/',
		},
	}
};

gulp.task('js', function () {
	return new Promise(function (resolve, reject) {
		es.concat(
			gulp.src(config.paths.js.src_frontend)
				.pipe(rigger())
				.pipe(concat('script.js'))
				.pipe(gulp.dest(config.paths.js.build_frontend)),
			gulp.src(config.paths.js.src_backend)
				.pipe(rigger())
				.pipe(concat('script.js'))
				.pipe(gulp.dest(config.paths.js.build_backend))
				.pipe(gulp.dest(config.paths.js.application_backend))
		);
		resolve();
	});
});

gulp.task('sass', function () {
	return new Promise(function (resolve, reject) {
		es.concat(gulp.src(config.paths.css.src_backend)
				.pipe(sass())
				.pipe(autoprefixer({
					overrideBrowserslist: ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11'],
					cascade: false
				}))
				.pipe(cssminify({compatibility: 'ie8'}))
				.pipe(concat('style.css'))
				.pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.css.build_backend))
				.pipe(gulp.dest(config.paths.css.application_backend)),

			gulp.src(config.paths.css.src_frontend)
				.pipe(sass())
				.pipe(autoprefixer({
					overrideBrowserslist: ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11'],
					cascade: false
				}))
				.pipe(cssminify({compatibility: 'ie8'}))
				.pipe(concat('style.css'))
				.pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.css.build_frontend))
		);
		resolve();
	});
});

gulp.task('html', function () {
	return new Promise(function (resolve, reject) {
		es.concat(gulp.src(config.paths.html.src_backend)
				.pipe(includeHtml()).pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.html.build_backend)),

			gulp.src(config.paths.html.src_frontend)
				.pipe(includeHtml()).pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.html.build_frontend))
		);
		resolve();
	});
});

gulp.task('browser-sync', function () {
	browserSync.init({
		disable: false,
		server: {
			baseDir: "./build"
		},
		host: 'localhost',
		port: 8006,
		logPrefix: "kotofey-develop"

	});
});

gulp.task('copy', function () {
	return new Promise(function (resolve, reject) {
		gulp.src(config.paths.copy.src_frontend)
		// .pipe(changed(config.copy.build, {hasChanged: changed.compareLastModifiedTime}))
			.pipe(gulp.dest(config.paths.copy.build_frontend))
			.pipe(browserSync.reload({
				stream: true
			}));
		resolve();
	});
});
gulp.task('img', function () {
	return new Promise(function (resolve, reject) {
		gulp.src(config.paths.image.src_frontend)
			.pipe(changed(config.paths.image.build_frontend, {hasChanged: changed.compareLastModifiedTime}))
			.pipe(imagemin([
				imagemin.gifsicle({interlaced: false}),
				imagemin.jpegtran({progressive: false}),
				imagemin.optipng({optimizationLevel: 7}),
				imagemin.svgo({
					plugins: [
						{removeViewBox: true},
						{cleanupIDs: false}
					]
				})
			]))
			.pipe(gulp.dest(config.paths.image.build_frontend))
			.pipe(browserSync.reload({
				stream: true
			}));

		resolve();
	});
});

gulp.task('build', gulp.parallel(
	'sass',
	'html',
	'js',
	'img',
	'copy'
))
;

gulp.task('watch', function () {
	gulp.watch([config.paths.css.watch_backend, config.paths.css.watch_frontend], gulp.series('sass'));
	gulp.watch([config.paths.html.watch_backend, config.paths.html.watch_frontend], gulp.series('html'));
	gulp.watch([config.paths.js.watch_backend, config.paths.js.watch_frontend], gulp.series('js'));
	gulp.watch([config.paths.image.watch_backend, config.paths.image.watch_frontend], gulp.series('img'));
	gulp.watch([config.paths.copy.watch_backend, config.paths.copy.watch_frontend], gulp.series('copy'));
});

gulp.task('default', gulp.series('build', gulp.parallel('watch', 'browser-sync')));