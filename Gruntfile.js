module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({

        // Metadata.
        pkg: grunt.file.readJSON('package.json'),

        // Task configuration.
        jshint: {
            all: [
                'app-js/**/*.js',
                'tests/js/spec/**/*.js'
            ],
            options: {
                jshintrc: './jshint.jshintrc'
            }
        },
        concat: {
            options: {
                separator: ';',
            },
            dist: {
                src: ['app-js/**/*.js'],
                dest: 'public/consolidated.js',
            }
        },
        uglify: {
            target: {
                files: {
                    'public/main-min.js': ['public/consolidated.js']
                }
            }
        },
        jasmine: {
            all: {
                src: [
                    'app-js/src/**/*.js',
                ],
                options: {
                    'vendor': 'bower_components/jquery/dist/jquery.min.js',
                    'specs': 'tests/js/spec/**/*.js'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jasmine');

    // "npm test" runs these tasks
    grunt.registerTask('test', ['jasmine']);

    // Default task.
    grunt.registerTask('default', ['test']);

};