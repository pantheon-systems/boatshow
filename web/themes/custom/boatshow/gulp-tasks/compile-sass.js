/**
 * @file
 * Task: Compile: Sass.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('compile:sass', function () {
    return gulp.src([
      options.sass.files
    ])
      .pipe(plugins.plumber())
      .pipe(plugins.sourcemaps.init())
      .pipe(plugins.sassGlob())
      .pipe(plugins.sass({
        errLogToConsole: true,
        outputStyle: 'expanded',
        importer: plugins.nodeSassGlobbing
      }))
      .pipe(plugins.autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
      }))
      .pipe(plugins.sourcemaps.write('./'))
      .pipe(gulp.dest(options.sass.destination));
  });
};
