(function() {
  var _, log;

  log = require('util').log;

  _ = require('lodash');

  module.exports = function(grunt) {
    var allExamples, allExamplesOpen, allExamplesTaskToRun, dev, exampleOpenTasks, listWithQuotes, options, showOpenType;
    require('./grunt/bower')(grunt);
    ["grunt-contrib-uglify", "grunt-contrib-jshint", "grunt-contrib-concat", "grunt-contrib-clean", "grunt-contrib-connect", "grunt-contrib-copy", "grunt-contrib-watch", "grunt-open", "grunt-mkdir", "grunt-contrib-coffee", "grunt-contrib-jasmine", "grunt-conventional-changelog", "grunt-bump", 'grunt-replace', 'grunt-subgrunt', 'grunt-debug-task', 'grunt-curl', 'grunt-verbosity', 'grunt-webpack', 'grunt-angular-architecture-graph'].forEach(function(gruntLib) {
      return grunt.loadNpmTasks(gruntLib);
    });
    options = require('./grunt/options')(grunt);
    allExamples = grunt.file.expand('example/*.html');
    allExamplesOpen = {};
    allExamples.forEach(function(path) {
      var pathValue, root;
      root = path.replace('example/', '').replace('.html', '');
      pathValue = "http://localhost:3100/" + path;
      return allExamplesOpen[root] = {
        path: pathValue
      };
    });
    showOpenType = function(toIterate) {
      if (toIterate == null) {
        toIterate = allExamplesOpen;
      }
      return _(toIterate).each(function(v, k) {
        return log(k + " -> " + v.path);
      });
    };
    options.open = _.extend(options.open, allExamplesOpen);
    grunt.initConfig(options);
    grunt.registerTask("default", ['bower', 'curl', 'verbosity', 'clean:dist', 'jshint', 'mkdir', 'coffee', 'concat:libs', 'replace', 'webpack', 'concat:dist', 'concat:streetview', 'copy', 'uglify:dist', 'uglify:streetview', 'jasmine:consoleSpec']);
    grunt.registerTask("spec", ['bower', 'curl', 'verbosity', "clean:dist", "jshint", "mkdir", "coffee", "concat:libs", "replace", "webpack", "concat", "copy", "connect:jasmineServer", "jasmine:spec", "open:jasmine", "watch:spec"]);
    grunt.registerTask("coverage", ['bower', 'curl', "clean:dist", "jshint", "mkdir", "coffee", "concat:libs", "replace", "concat:dist", "copy", "uglify:dist", "jasmine:coverage"]);
    grunt.registerTask('default-no-specs', ["clean:dist", "jshint", "mkdir", "coffee", "concat:libs", "replace", "concat:dist", "copy", "uglify:dist"]);
    grunt.registerTask('offline', ['default-no-specs', 'watch:offline']);
    dev = ["clean:dist", "jshint", "mkdir", "coffee", "concat:libs", "replace", "webpack", "concat", "copy"];
    grunt.registerTask("dev", dev.concat(["uglify:distMapped", "uglify:streetviewMapped", "jasmine:spec"]));
    grunt.registerTask("fast", dev.concat(["jasmine:spec"]));
    grunt.registerTask("mappAll", ['bower', 'curl', "clean:dist", "jshint", "mkdir", "coffee", "concat:libs", "replace", "webpack", "concat", "uglify", "copy", "jasmine:spec", "graph"]);
    grunt.registerTask("build-street-view", ['clean:streetview', 'mkdir', 'coffee', 'concat:libs', 'replace', 'concat:streetview', 'concat:streetviewMapped', 'uglify:streetview', 'uglify:streetviewMapped']);
    grunt.registerTask("buildAll", "mappAll");
    grunt.registerTask('graph', ['angular_architecture_graph']);
    grunt.registerTask('bump-@-preminor', ['changelog', 'bump-only:preminor', 'mappAll', 'bump-commit']);
    grunt.registerTask('bump-@-prerelease', ['changelog', 'bump-only:prerelease', 'mappAll', 'bump-commit']);
    grunt.registerTask('bump-@', ['changelog', 'bump-only', 'mappAll', 'bump-commit']);
    grunt.registerTask('bump-@-minor', ['changelog', 'bump-only:minor', 'mappAll', 'bump-commit']);
    grunt.registerTask('bump-@-major', ['changelog', 'bump-only:major', 'mappAll', 'bump-commit']);
    exampleOpenTasks = [];
    _.each(allExamplesOpen, function(v, key) {
      var basicTask;
      basicTask = "open:" + key;
      grunt.registerTask(key, ["fast", "clean:example", "connect:server", basicTask, "watch:all"]);
      return exampleOpenTasks.push(basicTask);
    });
    allExamplesTaskToRun = ["fast", "clean:example", "connect:server"].concat(exampleOpenTasks).concat(['watch:all']);
    listWithQuotes = function(collection, doLog) {
      var all, last;
      if (doLog == null) {
        doLog = true;
      }
      last = collection.length - 1;
      all = '';
      collection.forEach(function(t, i) {
        return all += i < last ? "'" + t + "'," : "'" + t + "'";
      });
      if (doLog) {
        return log(all);
      }
      return all;
    };
    grunt.registerTask('listExamples', showOpenType);
    grunt.registerTask('listAllOpen', function() {
      return showOpenType(options.open);
    });
    grunt.registerTask('listAllExamplesTasks', function() {
      return listWithQuotes(exampleOpenTasks);
    });
    grunt.registerTask('allExamples', allExamplesTaskToRun);
    grunt.registerTask('server', ["connect:server", "watch:all"]);
    return grunt.registerTask('s', 'server');
  };

}).call(this);

