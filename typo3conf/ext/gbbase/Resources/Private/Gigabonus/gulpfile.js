var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'bower_components/normalize.scss/sass',
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

/*
 *  @summary For sprites config only, generating sprite css and image
 *  @author danish
 */
var csso = require('gulp-csso');
var buffer = require('vinyl-buffer');
var merge = require('merge-stream');
var spritesmith = require('gulp.spritesmith');
var del = require('del');

/*
function sprite() {
    var spriteData = gulp.src('src/assets/img/sprite/*.png')
        .pipe(spritesmith({
            imgName: '../img/sprite.png',
            cssName: '_sprite.scss'
        }));
    var spriteImg = spriteData.img.pipe(gulp.dest('src/assets/img'));
    var spriteCss = spriteData.css.pipe(gulp.dest('src/assets/scss/modules/'));
    return (spriteImg && spriteCss);
}
*/

// sprite
gulp.task('sprite', function () {
    var spriteData = gulp.src('src/assets/img/sprite/*.png')
        .pipe(spritesmith({
            imgName: '../img/sprite.png',
            cssName: '_sprite.scss'
        }));
    var spriteImg = spriteData.img.pipe(gulp.dest('src/assets/img'));
    var spriteCss = spriteData.css.pipe(gulp.dest('scss/'));
    return (spriteImg && spriteCss);
});

// Clean sprite
gulp.task('clean:sprite', function() {
    return del([
        'src/assets/img/sprite.png',
    ]);
});


gulp.task('sass', function() {
  return gulp.src('scss/app.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'expanded'
      // outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('../../Public/Css'));
});

gulp.task('default', ['sass'], function() {
    gulp.watch(['scss/**/*.scss'], ['sass']);

    gulp.watch(['src/assets/img/sprite/**/*.png'], ['clean:sprite', 'sprite'])
    .on('change', function(event) {
            // logFileChange(event);
    });
});
