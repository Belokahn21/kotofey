var gulp = require('gulp'),
	browserSync = require('browser-sync').create(),
	reload = browserSync.reload,
	autoprefixer = require('gulp-autoprefixer'),
	includeHtml = require('gulp-include-tag'),
	es = require('event-stream'),
	concat = require('gulp-concat'),
	rigger = require('gulp-rigger'),
	cssminify = require('gulp-clean-css'),
	changed = require('gulp-changed'),
	imagemin = require('gulp-imagemin'),
	babel = require('gulp-babel'),
	ugli = require('gulp-uglify'),
	plumber = require('gulp-plumber'),
	sass = require('gulp-sass'),
	browserify = require('browserify'),
	buffer = require('vinyl-buffer'),
	source = require('vinyl-source-stream'),
	pug = require('gulp-pug'),
	notify = require('gulp-notify'),
	babelify = require('babelify');

const config = {
	paths: {
		css: {
			src_backend: './src/backend/style/scss/*.{sass,scss}',
			watch_backend: './src/backend/style/scss/**/*.{sass,scss}',
			build_backend: './build/backend/assets/css/',
			application_backend: '../application/web/css/',

			src_frontend: './src/frontend/style/scss/*.{sass,scss}',
			watch_frontend: './src/frontend/style/scss/**/*.{sass,scss}',
			build_frontend: './build/frontend/assets/css/',
			application_frontend: '../application/web/css/',
		},
		html: {
			src_backend: './src/backend/html/*.{html,htm}',
			watch_backend: './src/backend/html/**/*.{html,htm}',
			build_backend: './build/backend/',

			src_frontend: './src/frontend/html/*.{html,htm}',
			watch_frontend: './src/frontend/html/**/*.{html,htm}',
			build_frontend: './build/frontend/',

		},
		pug: {
			src_backend: './src/backend/pug/*.pug',
			watch_backend: './src/backend/pug/**/*.pug',
			build_backend: './build/backend/',

			src_frontend: './src/frontend/pug/*.pug',
			watch_frontend: './src/frontend/pug/**/*.pug',
			build_frontend: './build/frontend/',
		},
		js: {
			src_backend: './src/backend/js/*.js',
			watch_backend: './src/backend/js/**/*.js',
			build_backend: './build/backend/assets/js/',
			application_backend: '../application/web/js/',

			src_frontend: './src/frontend/js/*.js',
			watch_frontend: './src/frontend/js/**/*.js',
			build_frontend: './build/frontend/assets/js/',
			application_frontend: '../application/web/js/',
		},
		image: {
			src_backend: './src/backend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			watch_backend: './src/backend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			build_backend: './build/backend/assets/images/',
			application_backend: '../application/web/upload/images/',

			src_frontend: './src/frontend/images/**/*.{png,jpg,jpeg,svg,gif}',
			watch_frontend: './src/frontend/images/**/*.{png,jpg,jpeg,svg,gif}',
			build_frontend: './build/frontend/assets/images/',
			application_frontend: '../application/web/upload/images/',
		},
		copy: {
			src_backend: './src/backend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			watch_backend: './src/backend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			build_backend: './build/backend/assets/images/',
			application_backend: '../application/web/upload/images/',

			src_frontend: './src/frontend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			watch_frontend: './src/frontend/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
			build_frontend: './build/frontend/assets/images/',
			application_frontend: '../application/web/upload/images/',
		},
		ecmascript6: {
			src_backend: './src/backend/js/ecmascript6/core.js',
			watch_backend: './src/backend/js/**/*.js',
			build_backend: './build/backend/assets/js/',
			application_backend: '../application/web/js/',

			src_frontend: './src/frontend/js/ecmascript6/core.js',
			watch_frontend: './src/frontend/js/ecmascript6/**/*.js',
			build_frontend: './build/frontend/assets/js/',
			application_frontend: '../application/web/js/'

		},
	}
};
gulp.task('ecmascript6', function () {
	return new Promise(function (resolve, reject) {
		es.concat(browserify({
			entries: ['node_modules/@babel/polyfill/dist/polyfill.min.js', config.paths.ecmascript6.src_backend],
			debug: true
		})
			.transform('babelify', {
				presets: ['@babel/env'],
				global: true,
				ignore: [/\/node_modules\/(?!bootstrap\/)/]
			}).bundle()
			.pipe(source('backend-core.min.js'))
			.pipe(buffer())
			.pipe(plumber({
				errorHandler: notify.onError(function (err) {
					return {
						title: 'scripts',
						message: err.message
					}
				})
			}))
			.pipe(ugli())
			// .pipe(gulpif(!!config.ecmascript6.sourcemapsPath, sourcemaps.write('.')))
			.pipe(plumber.stop())
			.pipe(gulp.dest(config.paths.ecmascript6.build_backend))
			.pipe(gulp.dest(config.paths.ecmascript6.application_backend))
			.pipe(browserSync.reload({
				stream: true
			})),
			browserify({
				entries: ['node_modules/@babel/polyfill/dist/polyfill.min.js', config.paths.ecmascript6.src_frontend],
				debug: true
			})
				.transform('babelify', {
					presets: ['@babel/env'],
					global: true,
					ignore: [/\/node_modules\/(?!bootstrap\/)/]
				}).bundle()
				.pipe(source('frontend-core.min.js'))
				.pipe(buffer())
				.pipe(plumber({
					errorHandler: notify.onError(function (err) {
						return {
							title: 'scripts',
							message: err.message
						}
					})
				}))
				.pipe(ugli())
				// .pipe(gulpif(!!config.ecmascript6.sourcemapsPath, sourcemaps.write('.')))
				.pipe(plumber.stop())
				.pipe(gulp.dest(config.paths.ecmascript6.build_frontend))
				.pipe(gulp.dest(config.paths.ecmascript6.application_frontend))
				.pipe(browserSync.reload({
					stream: true
				}))
		);
		resolve();
	});
});
// gulp.task('ecmascript6', function () {
// 	return new Promise(function (resolve, reject) {
// 		es.concat(browserify({
// 				entries: ['node_modules/@babel/polyfill/dist/polyfill.min.js', config.paths.ecmascript6.src_frontend],
// 				debug: true
// 			}).transform('babelify', {
// 				presets: ['@babel/env'],
// 				compact: false
// 			}).bundle()
// 				.pipe(plumber())
// 				.pipe(source('core.min.js'))
// 				// .pipe(babel({compact: false}))
// 				.pipe(buffer())
// 				.pipe(ugli())
// 				.pipe(plumber.stop())
// 				.pipe(gulp.dest(config.paths.ecmascript6.build_frontend))
// 				.pipe(gulp.dest(config.paths.ecmascript6.application_frontend)),
//
// 			browserify({
// 				entries: ['node_modules/@babel/polyfill/dist/polyfill.min.js', config.paths.ecmascript6.src_backend],
// 				debug: true
// 			}).transform('babelify', {
// 				presets: ['@babel/env'],
// 			}).bundle()
// 				.pipe(plumber())
// 				.pipe(source('backend-core.min.js'))
// 				// .pipe(babel({compact: false}))
// 				.pipe(buffer())
// 				.pipe(ugli())
// 				.pipe(plumber.stop())
// 				.pipe(gulp.dest(config.paths.ecmascript6.build_backend))
// 				.pipe(gulp.dest(config.paths.ecmascript6.application_backend)));
// 		resolve();
// 	});
// });

gulp.task('js', function () {
	return new Promise(function (resolve, reject) {
		gulp.src(config.paths.js.src_frontend)
			.pipe(plumber())
			.pipe(rigger())
			.pipe(babel({compact: true}))
			.pipe(concat('script.min.js'))
			.pipe(ugli())
			.pipe(plumber.stop())
			.pipe(gulp.dest(config.paths.js.build_frontend))
			.pipe(gulp.dest(config.paths.js.application_frontend));
		resolve();
	});
});

gulp.task('pug', function () {
	return new Promise(function (resolve, reject) {
		gulp.src(config.paths.pug.src_backend)
			.pipe(plumber())
			.pipe(pug())
			.pipe(plumber.stop())
			.pipe(gulp.dest(config.paths.pug.build_backend))
			.pipe(reload({stream: true}));

		gulp.src(config.paths.pug.src_frontend)
			.pipe(pug())
			.pipe(gulp.dest(config.paths.pug.build_frontend))
			.pipe(reload({stream: true}));
		resolve();
	});
});

gulp.task('sass', function () {
	return new Promise(function (resolve, reject) {
		es.concat(gulp.src(config.paths.css.src_backend)
				.pipe(plumber())
				.pipe(sass())
				.pipe(autoprefixer({
					overrideBrowserslist: ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11'],
					cascade: false
				}))
				.pipe(cssminify({compatibility: 'ie8'}))
				.pipe(concat('backend.min.css'))
				.pipe(plumber.stop())
				.pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.css.build_backend))
				.pipe(gulp.dest(config.paths.css.application_backend)),

			gulp.src(config.paths.css.src_frontend)
				.pipe(plumber())
				.pipe(sass())
				.pipe(autoprefixer({
					overrideBrowserslist: ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11'],
					cascade: false
				}))
				.pipe(cssminify({compatibility: 'ie8'}))
				.pipe(concat('style.min.css'))
				.pipe(reload({stream: true}))
				.pipe(plumber.stop())
				.pipe(gulp.dest(config.paths.css.build_frontend))
				.pipe(gulp.dest(config.paths.css.application_frontend))
		);
		resolve();
	});
});

gulp.task('html', function () {
	return new Promise(function (resolve, reject) {
		es.concat(gulp.src(config.paths.html.src_backend)
				.pipe(plumber())
				.pipe(includeHtml())
				.pipe(plumber.stop())
				.pipe(reload({stream: true}))
				.pipe(gulp.dest(config.paths.html.build_backend)),

			gulp.src(config.paths.html.src_frontend)
				.pipe(plumber())
				.pipe(includeHtml())
				.pipe(plumber.stop())
				.pipe(reload({stream: true}))
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
		es.concat(
			gulp.src(config.paths.copy.src_frontend)
				.pipe(changed(config.paths.copy.build_frontend, {hasChanged: changed.compareLastModifiedTime}))
				.pipe(gulp.dest(config.paths.copy.build_frontend))
				.pipe(gulp.dest(config.paths.copy.application_frontend))
				.pipe(browserSync.reload({
					stream: true
				})),
			gulp.src(config.paths.copy.src_backend)
				.pipe(changed(config.paths.copy.build_backend, {hasChanged: changed.compareLastModifiedTime}))
				.pipe(gulp.dest(config.paths.copy.build_backend))
				.pipe(gulp.dest(config.paths.copy.application_backend))
				.pipe(browserSync.reload({
					stream: true
				}))
		);
		resolve();
	});
});
gulp.task('img', function () {
	return new Promise(function (resolve, reject) {
		es.concat(
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
				.pipe(gulp.dest(config.paths.image.application_frontend))
				.pipe(browserSync.reload({stream: true})),
			gulp.src(config.paths.image.src_backend)
				.pipe(changed(config.paths.image.build_backend, {hasChanged: changed.compareLastModifiedTime}))
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
				.pipe(gulp.dest(config.paths.image.build_backend))
				.pipe(gulp.dest(config.paths.image.application_backend))
				.pipe(browserSync.reload({stream: true}))
		);

		resolve();
	});
});

gulp.task('build', gulp.parallel(
	'sass',
	'pug',
	// 'html',
	// 'js',
	'img',
	'copy',
	'ecmascript6'
));

gulp.task('watch', function () {
	gulp.watch([config.paths.css.watch_backend, config.paths.css.watch_frontend], gulp.series('sass'));
	// gulp.watch([config.paths.html.watch_backend, config.paths.html.watch_frontend], gulp.series('html'));
	// gulp.watch([config.paths.js.watch_frontend], gulp.series('js'));
	gulp.watch([config.paths.ecmascript6.watch_backend, config.paths.ecmascript6.watch_frontend], gulp.series('ecmascript6'));
	gulp.watch([config.paths.image.watch_backend, config.paths.image.watch_frontend], gulp.series('img'));
	gulp.watch([config.paths.copy.watch_backend, config.paths.copy.watch_frontend], gulp.series('copy'));
	gulp.watch([config.paths.pug.watch_backend, config.paths.pug.watch_frontend], gulp.series('pug'));
});

gulp.task('default', gulp.series('build', gulp.parallel('watch', 'browser-sync')));