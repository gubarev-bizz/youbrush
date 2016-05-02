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

gulp.task('build', ['fonts', 'less', 'scripts:bundle', 'bower-css', 'scripts:adminLTE', 'styles:adminLTE', 'js', 'js:admin']);

gulp.task('clean', function (cb) {
    del(['web/css/*', 'web/js/*', 'web/fonts/*'], cb);
});

gulp.task('bower-css', function() {
    return gulp.src([
        'bower_components/components-font-awesome/css/font-awesome.min.css',
        'bower_components/bootstrap/dist/css/bootstrap.min.css'
    ])
        .pipe(plumber())
        .pipe(uglifycss())
        .pipe(plumber.stop())
        .pipe(concat('core.css'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('styles:adminLTE', function() {
    return gulp.src([
        'bower_components/AdminLTE/dist/css/AdminLTE.css',
        'bower_components/AdminLTE/dist/css/skins/_all-skins.css'
    ])
        .pipe(plumber())
        .pipe(uglifycss())
        .pipe(plumber.stop())
        .pipe(concat('admin.css'))
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
    return gulp.src([
        'node_modules/bootstrap/fonts/*', 'web-src/fonts/*',
        'bower_components/components-font-awesome/fonts/*', 'web-src/fonts/*'
    ]).pipe(gulp.dest('web/fonts'))
});

gulp.task('js', function() {
    return gulp.src(['web-src/js/**/*.js'])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        .pipe(concat('site.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('js:admin', function() {
    return gulp.src(['web-src/js/**/*.js'])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        .pipe(concat('admin-script.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('scripts:bundle', function() {
    return gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'bower_components/bootstrap/js/affix.js',
        'bower_components/bootstrap/js/alert.js',
        'bower_components/bootstrap/js/button.js',
        'bower_components/bootstrap/js/dropdown.js',
        'bower_components/bootstrap/js/popover.js',
        'bower_components/bootstrap/js/tooltip.js',
        'bower_components/bootstrap/js/transition.js'
    ])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('core.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('scripts:adminLTE', function() {
    return gulp.src([
        'bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js',
        'bower_components/AdminLTE/bootstrap/js/bootstrap.js',
        'bower_components/AdminLTE/bootstrap/dist/js/app.js',
        'bower_components/bootstrap/js/affix.js',
        'bower_components/bootstrap/js/alert.js',
        'bower_components/bootstrap/js/button.js',
        'bower_components/bootstrap/js/dropdown.js',
        'bower_components/bootstrap/js/popover.js',
        'bower_components/bootstrap/js/tooltip.js',
        'bower_components/bootstrap/js/transition.js',
        'bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.js',
        'bower_components/AdminLTE/dist/js/demo.js'
    ])
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('admin.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/js'));
});

gulp.task('watch', ['build'], function () {
    gulp.watch('web-src/js/**/*.js', ['js']);
    gulp.watch('web-src/fonts/**/*', ['fonts']);
    gulp.watch('web-src/less/*.less', ['less']);
});