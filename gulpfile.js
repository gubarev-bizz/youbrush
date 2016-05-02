var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    uglifycss = require('gulp-uglifycss'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps'),
    less = require('gulp-less-sourcemap'),
    path = require('path'),
    plumber = require('gulp-plumber');

gulp.task('default', ['build']);

gulp.task('build', ['fonts', 'bower-css', 'less', 'bower-js', 'js']);

gulp.task('clean', function (cb) {
    del(['web/css/*', 'web/js/*', 'web/fonts/*'], cb);
});

gulp.task('bower-css', function() {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.min.css'
    ])
        .pipe(plumber())
        .pipe(uglifycss())
        .pipe(plumber.stop())
        .pipe(concat('core.css'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('less', function () {
    gulp.src('web-src/less/**/*.less')
        .pipe(less({
            sourceMap: {
                sourceMapRootpath: 'web-src/less/' // Optional absolute or relative path to your LESS files
            }
        }))
        .pipe(uglify())
        .pipe(concat('admin.css'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/dist/fonts/*', 'web-src/fonts/*'])
        .pipe(gulp.dest('web/fonts'))
});

gulp.task('js', function() {
    return gulp.src(['web-src/js/**/*.js'])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        .pipe(concat('site.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('bower-js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js'
    ])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('core.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('watch', ['build'], function () {
    gulp.watch('web-src/js/**/*.js', ['js']);
    gulp.watch('web-src/fonts/**/*', ['fonts']);
    gulp.watch('web-src/less/*.less', ['less']);
});