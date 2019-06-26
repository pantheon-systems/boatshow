/**
 * @file
 * Task: Watch.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('watch', ['watch:sass', 'watch:styleguide', 'watch:js', 'watch:lint']);

  gulp.task('watch:js', function () {
    return gulp.watch([
      options.js.files
    ], function () {
      plugins.runSequence(
        'compile:js',
        'browser-sync:reload'
      );
    });
  });

  gulp.task('watch:sass', function () {
    return gulp.watch([
      options.sass.files
    ], function () {
      plugins.runSequence(
        'compile:sass',
        'minify:css',
        'browser-sync:reload'
      );
    });
  });

  gulp.task('watch:styleguide', function () {
    return gulp.watch([
      options.styleGuide.files
    ], function () {
      plugins.runSequence(
        'compile:styleguide'
      );
    });
  });

  gulp.task('watch:lint', function () {
    return gulp.watch([
      options.sass.files,
      options.js.files
    ], function () {
      plugins.runSequence(
        'lint:css',
        'lint:js',
      );
    });
  });

  var connect = require('gulp-connect');

  gulp.task('watch:connect', function() {
    connect.server({
      root: 'styleguide',
      port: 8000
    });
  });
};
