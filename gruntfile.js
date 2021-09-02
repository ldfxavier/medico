module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            all: ['**/*/.DS_Store', '**/*/._*', '.DS_Store', '._*']
        },
        imagemin: {
            site: {
                files: [{
                    expand: true,
                    cwd: 'public/images/',
                    src: ['*.{png,jpg,gif}'],
                    dest: 'public/images/'
                }],
            },
            painel: {
                files: [{
                    expand: true,
                    cwd: 'public/images/painel/',
                    src: ['*.{png,jpg,gif}'],
                    dest: 'public/images/painel/'
                }]
            }
        },
        jshint: {
            dist: {
                src: ['resources/dev/**/*.js']
            },
            options: {
                esversion: 6
            }
        },
        concat: {
            options: {
                separator: '\r\n'
            },
            site: {
                src: grunt.file.readJSON('resources/js/site/include.json'),
                dest: 'public/js/site.js'
            },
            restrito: {
                src: grunt.file.readJSON('resources/js/restrito/include.json'),
                dest: 'public/js/restrito.js'
            },
            painel: {
                src: grunt.file.readJSON('resources/js/painel/include.json'),
                dest: 'public/js/painel.js'
            }
        },
        copy: {
            jssite: {
                files: [{
                    expand: true,
                    cwd: 'resources/js/site/pagina/',
                    src: '*.js',
                    dest: 'public/js/site'
                }]
            },
            jsrestrito: {
                files: [{
                    expand: true,
                    cwd: 'resources/js/restrito/pagina/',
                    src: '*.js',
                    dest: 'public/js/restrito'
                }]
            },
            jspainel: {
                files: [{
                    expand: true,
                    cwd: 'resources/js/painel/pagina/',
                    src: '*.js',
                    dest: 'public/js/painel'
                }]
            }
        },
        uglify: {
            padrao: {
                files: [{
                    expand: true,
                    cwd: 'public/js/',
                    src: '*.js',
                    dest: 'public/js/'
                }]
            },
            site: {
                files: [{
                    expand: true,
                    cwd: 'public/js/site',
                    src: '*.js',
                    dest: 'public/js/site'
                }]
            },
            restrito: {
                files: [{
                    expand: true,
                    cwd: 'public/js/restrito',
                    src: '*.js',
                    dest: 'public/js/restrito'
                }]
            },
            painel: {
                files: [{
                    expand: true,
                    cwd: 'public/js/painel',
                    src: '*.js',
                    dest: 'public/js/painel'
                }]
            }
        },
        cssmin: {
            site: {
                files: [{
                        'public/css/site.css': ['public/css/site.css']
                    },
                    {
                        expand: true,
                        cwd: 'public/css/site',
                        src: ['*.css'],
                        dest: 'public/css/site',
                        ext: '.css'
                    }
                ]
            },
            restrito: {
                files: [{
                        'public/css/restrito.css': ['public/css/restrito.css']
                    },
                    {
                        expand: true,
                        cwd: 'public/css/restrito',
                        src: ['*.css'],
                        dest: 'public/css/restrito',
                        ext: '.css'
                    }
                ]
            },
            painel: {
                files: [{
                        'public/css/painel.css': ['public/css/painel.css']
                    },
                    {
                        expand: true,
                        cwd: 'public/css/painel',
                        src: ['*.css'],
                        dest: 'public/css/painel',
                        ext: '.css'
                    }
                ]
            }
        },
        stylus: {
            options: {
                compress: false
            },
            site: {
                files: [{
                        'public/css/site.css': ['resources/css/site/padrao.styl']
                    },
                    {
                        expand: true,
                        cwd: 'resources/css/site/pagina',
                        src: '*.styl',
                        dest: 'public/css/site/',
                        ext: '.css'
                    }
                ]
            },
            restrito: {
                files: [{
                        'public/css/restrito.css': ['resources/css/restrito/padrao.styl']
                    },
                    {
                        expand: true,
                        cwd: 'resources/css/restrito/pagina',
                        src: '*.styl',
                        dest: 'public/css/restrito',
                        ext: '.css'
                    }
                ]
            },
            painel: {
                files: [{
                        'public/css/painel.css': ['resources/css/painel/padrao.styl']
                    },
                    {
                        expand: true,
                        cwd: 'resources/css/painel/pagina',
                        src: '*.styl',
                        dest: 'public/css/painel/',
                        ext: '.css'
                    }
                ]
            }
        },
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 8', 'ie 9']
            },
            site: {
                files: [{
                        'public/css/site.css': ['public/css/site.css'],
                    },
                    {
                        expand: true,
                        cwd: 'public/css/site',
                        src: '*.css',
                        dest: 'public/css/site',
                        ext: '.css'
                    }
                ]
            },
            restrito: {
                files: [{
                        'public/css/restrito.css': ['public/css/restrito.css'],
                    },
                    {
                        expand: true,
                        cwd: 'public/css/restrito',
                        src: '*.css',
                        dest: 'public/css/restrito',
                        ext: '.css'
                    }
                ]
            },
            painel: {
                files: [{
                        'public/css/painel.css': ['public/css/painel.css'],
                    },
                    {
                        expand: true,
                        cwd: 'public/css/painel',
                        src: '*.css',
                        dest: 'public/css/painel',
                        ext: '.css'
                    }
                ]
            }
        },
        watch: {
            css: {
                files: ['resources/css/**/*'],
                tasks: ['stylus'],
                options: {
                    spawn: false
                }
            },
            js: {
                files: ['resources/js/**/*'],
                tasks: ['concat', 'copy'],
                options: {
                    spawn: false
                }
            }
        },
        phplint: {
            app: ["app/**/*.php"],
            system: ["system/**/*.php"],
            config: ["config/**/*.php"],
            datebase: ["datebase/**/*.php"],
            resources: ['resources/**/*.php'],
            routes: ['routes/**/*.php'],
            tests: ['tests/**/*.php'],
            index: ["index.php"]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-stylus');
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks("grunt-phplint");

    grunt.registerTask('default', []);
    grunt.registerTask('producao', ['jshint', 'concat', 'uglify', 'stylus', 'autoprefixer', 'cssmin', 'clean', 'phplint']);
    grunt.registerTask('dev', ['watch']);

};