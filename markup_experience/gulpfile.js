var gulp = require('gulp'),
    browserSync = require('browser-sync').create(),
    reload = browserSync.reload,
    autoprefixer = require('gulp-autoprefixer'),
    includeHtml = require('gulp-include-tag'),
    pug = require('gulp-pug'),
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
    babelify = require('babelify');
var config = {
    paths: {
        css: {
            src_frontend: './src/style/scss/*.{sass,scss}',
            watch_frontend: './src/style/scss/**/*.{sass,scss}',
            build_frontend: './build/assets/css/',
        },
        html: {
            src_frontend: './src/html/*.{html,htm}',
            watch_frontend: './src/html/**/*.{html,htm}',
            build_frontend: './build/',
        },
        pug: {
            src_frontend: './src/pug/*.pug',
            watch_frontend: './src/pug/**/*.pug',
            build_frontend: './build',
        },
        js: {
            src_frontend: './src/js/*.js',
            watch_frontend: './src/js/**/*.js',
            build_frontend: './build/assets/js/',
        },
        image: {
            src_frontend: './src/images/**/*.{png,jpg,jpeg,svg,gif}',
            watch_frontend: './src/images/**/*.{png,jpg,jpeg,svg,gif}',
            build_frontend: './build/assets/images/',
        },
        copy: {
            src_frontend: './src/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
            watch_frontend: './src/images/**/*.{png,webp,jpg,jpeg,svg,gif}',
            build_frontend: './build/assets/images/',
        },
        ecmascript6: {
            src_frontend: './src/js/core.js',
            watch_frontend: './src/js/**/*.js',
            build_frontend: './build/assets/js/',
        },
    }
};
gulp.task('ecmascript6', function () {
    return new Promise(function (resolve, reject) {
        browserify({
            entries: ['node_modules/@babel/polyfill/dist/polyfill.min.js', config.paths.ecmascript6.src_frontend],
            debug: true
        }).transform('babelify', {
            presets: ['@babel/env'],
        }).bundle()
            .pipe(source('core.min.js'))
            .pipe(buffer())
            .pipe(plumber())
            .pipe(plumber.stop())
            .pipe(ugli())
            .pipe(gulp.dest(config.paths.ecmascript6.build_frontend));
        resolve();
    });
});

gulp.task('js', function () {
    return new Promise(function (resolve, reject) {
        gulp.src(config.paths.js.src_frontend)
            .pipe(plumber())
            .pipe(rigger())
            .pipe(babel())
            .pipe(concat('script.min.js'))
            .pipe(ugli())
            .pipe(plumber.stop())
            .pipe(gulp.dest(config.paths.js.build_frontend));
        resolve();
    });
});

gulp.task('sass', function () {
    return new Promise(function (resolve, reject) {
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
            .pipe(gulp.dest(config.paths.css.build_frontend));
        resolve();
    });
});

gulp.task('html', function () {
    return new Promise(function (resolve, reject) {
        gulp.src(config.paths.html.src_frontend)
            .pipe(plumber())
            .pipe(includeHtml())
            .pipe(plumber.stop())
            .pipe(reload({stream: true}))
            .pipe(gulp.dest(config.paths.html.build_frontend));
        resolve();
    });
});

gulp.task('pug', function () {
    return new Promise(function (resolve, reject) {
        gulp.src(config.paths.pug.src_frontend)
            .pipe(plumber())
            .pipe(pug({pretty: true}))
            .pipe(plumber.stop())
            .pipe(reload({stream: true}))
            .pipe(gulp.dest(config.paths.pug.build_frontend));
        resolve();
    });
});

gulp.task('copy', function () {
    return new Promise(function (resolve, reject) {
        gulp.src(config.paths.copy.src_frontend)
            .pipe(changed(config.paths.copy.build_frontend, {hasChanged: changed.compareLastModifiedTime}))
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
            .pipe(browserSync.reload({stream: true}));

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

gulp.task('build', gulp.parallel(
    'sass',
    'pug',
    'img',
    'copy',
    'ecmascript6'
));

gulp.task('watch', function () {
    gulp.watch([config.paths.css.watch_frontend], gulp.series('sass'));
    gulp.watch([config.paths.pug.watch_frontend], gulp.series('pug'));
    gulp.watch([config.paths.ecmascript6.watch_frontend], gulp.series('ecmascript6'));
    gulp.watch([config.paths.image.watch_frontend], gulp.series('img'));
    gulp.watch([config.paths.copy.watch_frontend], gulp.series('copy'));
});

gulp.task('default', gulp.series('build', gulp.parallel('watch', 'browser-sync')));