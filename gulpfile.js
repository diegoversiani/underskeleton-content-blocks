// Defining base pathes
var basePaths = {
    bower: './bower_components/',
    js: './js-src/'
};

// Defining requirements
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var ignore = require('gulp-ignore');
var rimraf = require('gulp-rimraf');
var runSequence = require('run-sequence');
var autoprefixer = require('gulp-autoprefixer');

// Run: 
// gulp sass
// Compiles SCSS files in CSS
gulp.task('sass', function () {
  return gulp.src('./sass/*.scss')
    .pipe(plumber())
    .pipe(sass())
    .pipe(gulp.dest('./css'));
});

// Run: 
// gulp watch
// Starts watcher. Watcher runs appropriate tasks on file changes
gulp.task('watch', function () {
  gulp.watch('./sass/**/*.scss', ['build-css']);
  gulp.watch('./js-src/**/*.js', ['build-scripts']);
});

// Run: 
// gulp build-css
// Builds css from scss and apply other changes.
gulp.task('build-css', function(callback){
  runSequence('cleancss', 'sass', 'autoprefixer', 'cssnano', callback);
});

// Run: 
// gulp
// Defines gulp default task
gulp.task('default', ['watch'], function () { });

// Run: 
// gulp nanocss
// Minifies CSS files
gulp.task('cssnano', function(){
  return gulp.src('./css/*.css')
    .pipe(plumber())
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano({discardComments: {removeAll: true}}))
    .pipe(gulp.dest('./css/'))
    .pipe(browserSync.stream());
}); 

gulp.task('cleancss', function() {
  return gulp.src('./css/*.css', { read: false }) // much faster 
    .pipe(rimraf());
});

gulp.task('autoprefixer', function(){
  return gulp.src(['./css/*.css', '!./css/*min.css'])
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(gulp.dest('./css/'));
});

// Run: 
// gulp build-scripts. 
// Uglifies and concat all JS files into one
gulp.task('build-scripts', function() {
  
  gulp.src([
      basePaths.js + 'admin-*.js'
    ])
    .pipe(concat('admin.js'))
    .pipe(gulp.dest('./js/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('./js/'));

  // gulp.src('./js/admin.js')
  //   .pipe(rename({suffix: '.min'}))
  //   .pipe(uglify())
  //   .pipe(gulp.dest('./js/'));

});
