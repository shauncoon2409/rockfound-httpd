// Include gulp
var gulp = require('gulp'),

    // General
    gutil       = require('gulp-util'),
    watch       = require('gulp-watch'),
    plumber     = require('gulp-plumber'),
    notify      = require('gulp-notify'),
    include     = require('gulp-include'),

    // Javascript
    jshint      = require('gulp-jshint'),

    // Styles
    sass        = require('gulp-ruby-sass'),
    autoprefix  = require('gulp-autoprefixer'),

    // Cleaning
    del         = require('del'),

    // Minify, rename, revision
    minifyCSS = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    rename = require("gulp-rename"),
    rev = require('gulp-rev'),

    cssWatch = 'assets/src/css/**/*.scss',
    cssDest = 'assets/dist/css',

    jsCompile = ['assets/src/js/*.js'],
    jsLint = ['js/**/*.js', '!js/_lib/**/*.js'],
    jsWatch = 'assets/src/js/**/*.js',
    jsDest = 'assets/dist/js',

    imgWatch = 'assets/src/images/**'
    imgDest = 'assets/dist/images';


// Compile Styles
gulp.task('sass', ['revision'], function() {
    return gulp.src( cssWatch )
        .pipe(plumber())
        .pipe(include())
        .pipe(sass({
            bundleExec: true,
            'sourcemap=none': true,
            require: ['bourbon', 'breakpoint', 'susy']
        }))
        .on('error', function (err) { gutil.log(err.message); })
        .pipe(autoprefix('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest( cssDest ))

        // minify
        .pipe(notify({ message: 'minifying styles' }))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifyCSS())
        .pipe(gulp.dest( cssDest ));
});

// Compile Javascript
gulp.task('scripts', ['lint', 'revision'], function() {
    return gulp.src( jsCompile )
        .pipe(plumber())
        .pipe(include())
        .pipe(gulp.dest( jsDest ))

        // minify
        .pipe(notify({ message: 'minifying scripts' }))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(  jsDest ));
});
gulp.task('lint', function() {
    return gulp.src( jsLint )
        .pipe(plumber())
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});


// Copy images
gulp.task('images', ['clean:images', 'images:build'], function() {

gulp.task('images:build', ['clean:images'], function() {
    return gulp.src( imgWatch )
        .pipe(gulp.dest( imgDest ));
});
gulp.task('images:clean', function (cb) {
    del([ imgDest ], cb);
});


gulp.task('revision', ['revision:clean', 'revision:build']);

gulp.task('revision:build', function () {
    return gulp.src([cssDest + '/*.min.css', jsDest + '/*.min.js'], {base: 'assets/dist'})
        .pipe(gulp.dest('assets/dist'))
        .pipe(rev())
        .pipe(gulp.dest('assets/dist'))
        .pipe(rev.manifest())
        .pipe(gulp.dest('assets/dist'));
});
gulp.task('revision:clean', function (cb) {
    del([cssDest + '/*.min-*.css', jsDest + '/*.min-*.js']);
});


// Watch Files For Changes
gulp.task('watch', function() {
    watch(jsWatch, function() {
        gulp.start('scripts');
    });
    watch(cssWatch, function () {
        gulp.start('sass');
    });
    watch(imgWatch, function() {
        gulp.start('images');
    });
});


// Build source
gulp.task('build', ['sass', 'scripts', 'images']);

// Default Task
gulp.task('default', ['sass', 'scripts', 'images', 'watch']);
