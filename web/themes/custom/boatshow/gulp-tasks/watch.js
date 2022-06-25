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

  gulp.task('watch:lint', function () {
    gulp.watch([options.sass.files, options.js.files], ['lint:css', 'lint:js']);
  });
};
