'use strict'

// ---------------------------
// gulp requires
// ---------------------------
var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var gulpIgnore = require('gulp-ignore');
var autoprefix = require('gulp-autoprefixer');
var cssmin = require('gulp-cssmin');
var rename = require("gulp-rename");
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var jshint = require('gulp-jshint');
var prettify = require('gulp-jsbeautifier');
var imagemin = require('gulp-imagemin');
var bless = require('gulp-bless');
var sass = require('gulp-sass');
var rtlcss = require('gulp-rtlcss');

// ---------------------------
// vars
// ---------------------------
var imgsDir = 'assets/img';
var scssDir = 'assets/scss';
var scssWatchedFiles = [scssDir + '/*.scss', scssDir + '/**/*.scss'];
var targetCSSDir = 'assets/css';
var JSDir = 'assets/js';
var targetJSDir = 'assets/js';
var targetPluginsDir = 'assets/plugins/_overrides';

// ---------------------------
// Tasks
// ---------------------------

gulp.task('compile-scss-dev', function() {
  // Smaller dev scss task
  gulp.src([scssDir + '/*.scss'])
    .pipe(gulpIgnore.exclude('_*.scss'))
    .pipe(sass({sourceComments: true}).on('error', sass.logError))
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('Main CSS compiled (scss)'))
    // Minified version
    .pipe(cssmin().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('Main CSS minified'));
});

// Task to compile scss
// ---------------------------
gulp.task('compile-scss', function() {
  // All CSS minus plugins
  gulp.src([scssDir + '/*.scss', scssDir + '/color-variations/*.scss'])
    .pipe(gulpIgnore.exclude('_*.scss'))
    .pipe(sass().on('error', sass.logError))
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('Main CSS compiled (scss)'))
    // Minified version
    .pipe(cssmin().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('Main CSS minified'));

  // IE version of main theme-style
  gulp.src(scssDir + '/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(prettify({indent_size: 2}))
    .pipe(rename({prefix: 'ie.'}))
    .pipe(bless({suffix: '-part'}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('IE CSS compiled (scss)'))
    // Minified version
    .pipe(cssmin().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(targetCSSDir))
    .pipe(notify('IE CSS minified (scss)'));
});

//gulp.task('compile-rtl', function() {
//  // Right to Left support
//  gulp.src(scssDir + '/*.scss')
//    .pipe(sass().on('error', sass.logError))
//    .pipe(rtlcss())
//    .pipe(prettify({indent_size: 2}))
//    .pipe(rename({prefix: 'rtl.'}))
//    .pipe(gulp.dest(targetCSSDir))
//    .pipe(notify('Right to Left CSS compiled (scss)'))
//    // Minified version
//    .pipe(cssmin().on('error', function(err) {
//      console.log(err);
//    }))
//    .pipe(rename({suffix: '.min'}))
//    .pipe(gulp.dest(targetCSSDir))
//    .pipe(notify('Right to Left CSS minified (scss)'));
//
//  // Right to Left Blessed
//  gulp.src(scssDir + '/*.scss')
//    .pipe(sass().on('error', sass.logError))
//    .pipe(rtlcss())
//    .pipe(prettify({indent_size: 2}))
//    .pipe(rename({prefix: 'ie.rtl.'}))
//    .pipe(bless({suffix: '-part'}))
//    .pipe(gulp.dest(targetCSSDir))
//    .pipe(notify('IE CSS compiled (scss)'))
//    // Minified version
//    .pipe(cssmin().on('error', function(err) {
//      console.log(err);
//    }))
//    .pipe(rename({suffix: '.min'}))
//    .pipe(gulp.dest(targetCSSDir))
//    .pipe(notify('IE CSS minified (scss)'));
//});

gulp.task('compile-plugins-css', function() {
  // Plugin overrides
  gulp.src(scssDir + '/plugins/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(targetPluginsDir))
    .pipe(notify('Plugin CSS compiled'))
    // Minified version
    .pipe(cssmin().on('error', function(err) {
      console.log(err);
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(targetPluginsDir))
    .pipe(notify('Plugin CSS minified'));
});

// Task compile JS
// ---------------------------
gulp.task('compile-js', function() {
  gulp.src(JSDir + '/script.js')
    //.pipe(concat('script.js'))
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(targetJSDir))
    .pipe(notify('JS minified'));
});

// Task prettify
// ---------------------------
gulp.task('prettify', function() {
  gulp.src([targetCSSDir + '/*.css', './*.htm', JSDir + '/script.js'])
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(function(file) {
      return file.base;
    }));
});

// Compress images
// ---------------------------
gulp.task('compress-imgs', function() {
  gulp.src(imgsDir + '/**')
    .pipe(imagemin())
    .pipe(gulp.dest(function(file) {
      return file.base;
    }));
});


// ---------------------------
// Watch
// ---------------------------
gulp.task('watch', function() {
  gulp.watch(scssWatchedFiles, ['compile-scss']);
  gulp.watch(scssDir + '/plugins/*.scss', ['compile-plugins-css']);
  gulp.watch(JSDir + '/script.js', ['compile-js']);
});

gulp.task('watch-dev', function() {
  gulp.watch(scssWatchedFiles, ['compile-scss-dev']);
  gulp.watch(scssDir + '/plugins/*.scss', ['compile-plugins-css']);
  gulp.watch(JSDir + '/script.js', ['compile-js']);
});


// Default tasks
gulp.task('default', ['compile-js', 'compile-scss', 'compile-plugins-css', 'prettify', 'compress-imgs', 'watch']);
