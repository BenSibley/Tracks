module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            basic_and_extras: {
                files: {
                    'js/build/production.js': ['js/fitvids.js', 'js/functions.js', 'js/placeholders.js'],
                    'js/build/customizer.js': ['js/customizer.js', 'js/multiple-select.js']
                }
            }
        },
        uglify: {
            dist: {
                files: {
                    'js/build/production.min.js': 'js/build/production.js',
                    'js/build/customizer.min.js': 'js/build/customizer.js',
                    'js/build/admin.min.js': 'js/admin.js',
                    'js/build/postMessage.min.js': 'js/postMessage.js'
                }
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
                files: ['sass/*.scss', 'sass/templates/*.scss', 'licenses/css/*.scss'],
                tasks: ['sass', 'autoprefixer', 'cssmin'],
                options: {
                    livereload: true,
                    spawn: false
                }
            }
        },
        sass: {
            dist: {
                files: {
                    'style.css': 'sass/style.scss',
                    'styles/custom-editor-style.css': 'sass/custom_editor_styles.scss',
                    'styles/style-customizer.css': 'sass/customizer.scss',
                    'styles/style-admin.css': 'sass/admin.scss',
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
                    'styles/custom-editor-style.css': 'styles/custom-editor-style.css',
                    'styles/style-customizer.css': 'styles/style-customizer.css',
                    'styles/style-admin.css': 'styles/style-admin.css',
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
        },
        makepot: {
            target: {
                options: {
                    domainPath: '/languages',
                    exclude: ['library/.*/.*'],
                    potFilename: 'tracks.pot',
                    type: 'wp-theme',
                    processPot: function( pot ) {
                        var translation,
                            excluded_meta = [
                                'Theme Name of the plugin/theme',
                                'Theme URI of the plugin/theme',
                                'Author of the plugin/theme',
                                'Author URI of the plugin/theme'
                            ];

                        for ( translation in pot.translations[''] ) {
                            if ( 'undefined' !== typeof pot.translations[''][ translation ].comments.extracted ) {
                                if ( excluded_meta.indexOf( pot.translations[''][ translation ].comments.extracted ) >= 0 ) {
                                    console.log( 'Excluded meta: ' + pot.translations[''][ translation ].comments.extracted );
                                    delete pot.translations[''][ translation ];
                                }
                            }
                        }

                        return pot;
                    }
                }
            }
        },
        excludeFiles: '--exclude "*.gitignore" --exclude ".sass-cache/" --exclude "*.DS_Store" --exclude ".git/" --exclude ".idea/" --exclude "gruntfile.js" --exclude "node_modules/" --exclude "package.json" --exclude "sass/" --exclude "style.css.map" --exclude "styles/custom-editor-style.css.map" --exclude "styles/style-admin.css.map" --exclude "styles/style-customizer.css.map" --exclude "licenses/css/full-width-images.css.map" --exclude "licenses/css/full-width.css.map" --exclude "licenses/css/two-column-images.css.map" --exclude "licenses/css/two-column.css.map"',
        shell: {
            zip: {
                command: [
                    // delete existing copies (if they exist)
                    'rm -R "/Users/bensibley/Dropbox/Compete Themes/Distribution/tracks" || true',
                    'rm -R "/Users/bensibley/Dropbox/Compete Themes/Distribution/tracks.zip" || true',
                    // copy folder without any project/meta files
                    'rsync -r "/Users/bensibley/Sites/Compete Themes/tracks/wp-content/themes/tracks" "/Users/bensibley/Dropbox/Compete Themes/Distribution/" <%= excludeFiles %>',
                    // open dist folder
                    'cd "/Users/bensibley/Dropbox/Compete Themes/Distribution/"',
                    // zip the tracks folder
                    'zip -r tracks.zip tracks'
                ].join('&&')
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
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-shell');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'watch', 'sass', 'autoprefixer', 'cssmin', 'compress', 'csslint', 'makepot', 'shell']);

};