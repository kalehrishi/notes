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
                dest: 'public/consolidated1.js',
            }
        },
        uglify: {
            target: {
                files: {
                    'public/main-min1.js': ['public/consolidated1.js']
                }
            }
        },
        jasmine: {
            all: {
                src: [
                    'app-js/Notes.js',
                    'app-js/**/*.js'
                ],
                options: {
                    'vendor': [
                        'bower_components/jquery/dist/jquery.min.js',
                        'tests/js/lib/mock-ajax.js',
                        'tests/js/lib/jasmine-jquery.js',
                        'tests/js/include-html.js'
                    ],
                    'specs': 'tests/js/spec/**/*.js'
                }
            }
        },
    });
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jasmine');

    // "npm test" runs these tasks
    grunt.registerTask('test', ['jshint', 'concat', 'uglify', 'jasmine']);

    // Default task.
    grunt.registerTask('default', ['test']);

};