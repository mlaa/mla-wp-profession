var gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
var sourcemaps = require('gulp-sourcemaps');

gulp.task('hello', function() {
  console.log('Hello Zell');
});

gulp.task('sass', function(){
  return gulp.src('assets/sass/style.scss')
    .pipe(sourcemaps.init())

     .pipe(sass()) // Using gulp-sass
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./'))
});

gulp.task('sass:watch', function () {
  gulp.watch('assets/sass/style.scss', ['sass']);
});

