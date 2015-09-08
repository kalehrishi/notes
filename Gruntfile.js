module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({

        // Metadata.
        pkg: grunt.file.readJSON('package.json'),

        // Task configuration.
        copy: {
            // makes all src relative to cwd
            main: {
                files: [
                {
                    expand: true,
                    cwd: 'bower_components/',
                    src: ['**'],
                    dest: 'public/lib/'
                }
                ],
            },
        },
        jshint: {
            all: [
                'app-js/**/*.js',
            ],
            options: {
                jshintrc: './jshint.jshintrc',
                reporter: 'jslint',
                reporterOutput: 'build/logs/checkstyle-js.xml'
                } 
        },
        concat: {
            options: {
                separator: ';',
            },
            dist: {
                src: ['app-js/Notes.js','app-js/**/*.js'],
                dest: 'public/lib/consolidated.js',
            }
        },
        uglify: {
            target: {
                files: {
                    'public/lib/main-min.js': ['public/lib/consolidated.js']
                }
            }
        },
	jasmine: {
		src: [
			'public/lib/main-min.js'
		     ],
		options: {
                    vendor: [
			'public/lib/jquery/dist/jquery.min.js',
			'public/lib/mustache.js',
			'tests/js/TemplateLoader.js',
			'tests/js/lib/mock-ajax.js',
			'tests/js/lib/jasmine-jquery.js'
                    ],
		    specs: ['tests/js/spec/**/*.js']
                }
        }
});

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jasmine');

    // "npm test" runs these tasks
    grunt.registerTask('test', ['copy', 'jshint', 'concat', 'uglify', 'jasmine']);

    // Default task.
    grunt.registerTask('default', ['test']);

};
