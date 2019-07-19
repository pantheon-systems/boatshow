/**
 * @file
 * Task: Watch.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('watch', ['watch:sass', 'watch:js', 'watch:lint']);

  gulp.task('watch:js', function () {
    gulp.watch([options.js.files], ['compile:js']);
  });

  gulp.task('watch:sass', function () {
    gulp.watch([options.sass.files], ['compile:sass']);
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
    gulp.watch([options.sass.files, options.js.files], ['lint:css', 'lint:js']);
  });

  var connect = require('gulp-connect');

  gulp.task('watch:connect', function() {
    connect.server({
      root: 'styleguide',
      port: 8000
    });
  });
};
