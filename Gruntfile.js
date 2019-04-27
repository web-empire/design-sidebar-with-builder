module.exports = function (grunt) {
    grunt.initConfig({
        copy: {
            main: {
                options: {
                    mode: true
                },
                src: [
                    '**',
                    '*.zip',
                    '!node_modules/**',
                    '!build/**',
                    '!css/sourcemap/**',
                    '!.git/**',
                    '!bin/**',
                    '!.gitlab-ci.yml',
                    '!bin/**',
                    '!tests/**',
                    '!phpunit.xml.dist',
                    '!*.sh',
                    '!*.map',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!phpunit.xml',
                    '!README.md',
                    '!sass/**',
                    '!codesniffer.ruleset.xml',
                    '!vendor/**',
                    '!composer.json',
                    '!composer.lock',
                    '!package-lock.json',
                    '!phpcs.xml.dist',
                ],
                dest: 'sidebar-using-page-builder/'
            }
        },

        compress: {
            main: {
                options: {
                    archive: 'design-sidebar-with-page-builder.zip',
                    mode: 'zip'
                },
                files: [
                    {
                        src: [
                            './sidebar-using-page-builder/**'
                        ]

                    }
                ]
            }
        },

        clean: {
            main: ["sidebar-using-page-builder"],
            zip: ["design-sidebar-with-page-builder.zip"],
        },

        makepot: {
            target: {
                options: {
                    domainPath: '/',
                    mainFile: 'sidebar-using-page-builder.php',
                    potFilename: 'languages/sidebar-using-page-builder.pot',
                    potHeaders: {
                        poedit: true,
                        'x-poedit-keywordslist': true
                    },
                    type: 'wp-plugin',
                    updateTimestamp: true
                }
            }
        },
        
        addtextdomain: {
            options: {
                textdomain: 'sidebar-using-page-builder',
            },
            target: {
                files: {
                    src: ['*.php', '**/*.php', '!node_modules/**', '!php-tests/**', '!bin/**', '!asset/bsf-core/**']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-wp-i18n');

    grunt.registerTask('i18n', ['addtextdomain', 'makepot']);
    grunt.registerTask('release', ['clean:zip', 'copy', 'compress', 'clean:main']);
    
};
