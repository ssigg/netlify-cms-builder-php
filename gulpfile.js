var gulp = require('gulp');

var clean = require('gulp-clean');
var zip = require('gulp-zip');

var bases = {
    root: 'dist/'
};

var paths = [
    'actions/*',
    'builder/**',
    'services/*',
    'vendor/**',
    'composer.lock',
    'dependencies.php'
];

gulp.task('clean', function() {
    return gulp.src(bases.root)
        .pipe(clean());
});

gulp.task('collect', [ 'clean' ], function() {
    return gulp.src(paths, { base: './' })
        .pipe(gulp.dest(bases.root));
});

gulp.task('zip', [ 'collect' ], function() {
    return gulp.src(bases.root + '**')
        .pipe(zip('netlify-cms-builder-php.zip'))
        .pipe(gulp.dest(bases.root));
});