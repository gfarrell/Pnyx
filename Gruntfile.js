/* global module, require */
module.exports = function(Grunt) {
    'use strict';

    // Load all of our tasks from NPM
    require('load-grunt-tasks')(Grunt);

    // Default task
    Grunt.registerTask('default', ['less:dev', 'autoprefixer:dev', 'watch']);

    // Main build task
    Grunt.registerTask('build', ['less:production', 'autoprefixer:production', 'requirejs']);

    Grunt.initConfig({
        // LESS task for processing our stylesheets
        // https://github.com/gruntjs/grunt-contrib-less
        // Two targets: dev, production
        less: {
            options: {
                paths: ['www/css', 'www/lib']
            },
            dev: {
                options: {
                    sourceMap: true,
                    compress: false,
                    cleancss: false
                },
                files: {
                    'www/dist/main.dev.css': 'www/css/main.less'
                }
            },
            production: {
                options: {
                    sourceMap: false,
                    compress: true,
                    cleancss: true
                },
                files: {
                    'www/dist/main.min.css': 'www/css/main.less'
                }
            }
        },
        // Autoprefixer task for prefixing CSS
        // http://css-tricks.com/autoprefixer/
        // https://github.com/ai/autoprefixer
        // https://github.com/nDmitry/grunt-autoprefixer
        autoprefixer: {
            dev: {
                files: {
                    'www/dist/main.dev.css': 'www/dist/main.dev.css'
                }
            },
            production: {
                files: {
                    'www/dist/main.min.css': 'www/dist/main.min.css'
                }
            }
        },
        // Require.js task for compiling javascript
        // https://github.com/gruntjs/grunt-contrib-requirejs
        // More info: https://github.com/jrburke/r.js/blob/master/build/example.build.js
        // This is for production only
        requirejs: {
            compile: {
                options: {
                    baseUrl: 'www/js',
                    mainConfigFile: 'www/js/main.js',
                    optimize: 'uglify',
                    keepBuildDir: true,
                    name: 'main',
                    out: 'www/dist/main.js'
                }
            }
        },
        // Watch task for watching files to build out
        // https://github.com/gruntjs/grunt-contrib-watch
        watch: {
            options: {
                livereload: true
            },
            styles: {
                files: ['www/css/*.less', 'www/css/**/*.less'],
                tasks: ['less:dev', 'autoprefixer:dev']
            },
            scripts: {
                files: ['www/js/*.js', 'www/js/**/*.js']
                // probably should add some jshint tasks in here at some point
            },
            pages: {
                files: ['*.php', '*.ctp']
            }
        }
    });
};