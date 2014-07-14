module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            dist: {
                src: [
                    'js/*.js'
                ],
                dest: 'js/build/production.js'
            }
        },
        uglify: {
            build: {
                src: 'js/build/production.js',
                dest: 'js/build/production.min.js'
            }
        },
        watch: {
            scripts: {
                files: ['js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false
                }
            },
            css: {
                files: ['sass/*.scss', 'licenses/css/*.scss'],
                tasks: ['sass', 'autoprefixer', 'cssmin'],
                options: {
                    livereload: true,
                    spawn: false
                }
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'style.css': 'sass/style.scss',
                    'custom-editor-styles.css': 'sass/_custom_editor_styles.scss',
                    'licenses/css/full-width.css': 'licenses/css/full-width.scss',
                    'licenses/css/full-width-images.css': 'licenses/css/full-width-images.scss',
                    'licenses/css/two-column.css': 'licenses/css/two-column.scss',
                    'licenses/css/two-column-images.css': 'licenses/css/two-column-images.scss'
                }
            }
        },
        autoprefixer: {
            dist: {
                options: {
                    browsers: ['last 1 version', '> 1%', 'ie 8']
                },
                files: {
                    'style.css': 'style.css',
                    'licenses/css/full-width.css': 'licenses/css/full-width.css',
                    'licenses/css/full-width-images.css': 'licenses/css/full-width-images.css',
                    'licenses/css/two-column.css': 'licenses/css/two-column.css',
                    'licenses/css/two-column-images.css': 'licenses/css/two-column-images.css'
                }
            }
        },
        cssmin: {
            combine: {
                files: {
                    'style.min.css': ['style.css'],
                    'licenses/css/full-width.min.css': ['licenses/css/full-width.css'],
                    'licenses/css/full-width-images.min.css': ['licenses/css/full-width-images.css'],
                    'licenses/css/two-column.min.css': ['licenses/css/two-column.css'],
                    'licenses/css/two-column-images.min.css': ['licenses/css/two-column-images.css']
                }
            }
        },
        compress: {
            main: {
                options: {
                    archive: '/Users/bensibley/Desktop/tracks.zip'
                },
                files: [
                    {
                        src: ['**', '!node_modules/**','!sass/**', '!gruntfile.js', '!package.json', '!style-prefixed.css','!/.git/','!/.idea/','!/.sass-cache/','!**.DS_Store'],
                        filter: 'isFile'
                    }
                ]
            }
        },
        csslint: {
            strict: {
                src: ['style.css']
            }
        }
    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-csslint');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'watch', 'sass', 'autoprefixer', 'cssmin', 'compress', 'csslint']);

};