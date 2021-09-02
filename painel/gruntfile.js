module.exports = function(grunt) {

	/**
	 * CONFIGURAÇÃO DOS PLUGINS
	**/
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		clean: {
			all: ['**/*/.DS_Store', '**/*/._*', '.DS_Store', '._*']
		},
		imagemin: {
			dynamic: {
				site: [{
					expand: true,
					cwd: 'images/',
					src: ['*.{png,jpg,gif}'],
					dest: 'images/'
				}],
				painel: [{
					expand: true,
					cwd: 'images/painel/',
					src: ['*.{png,jpg,gif}'],
					dest: 'images/painel/'
				}]
			}
		},
		jshint: {
			dist: {
				src: ['js/dev/painel/*.js', 'js/dev/site/*.js', 'js/dev/areadoassociado/*.js']
			}
		},
		concat: {
			site: {
				src: [
					'js/dev/geral/*.js',
					'js/dev/site/*.js'
				],
				dest: 'js/site.js'
			},
			painel: {
				src: [
					'js/dev/geral/*.js',
					'js/dev/painel/*.js'
				],
				dest: 'js/painel.js'
			},
			areadoassociado: {
				src: [
					'js/dev/geral/*.js',
					'js/dev/areadoassociado/*.js'
				],
				dest: 'js/areadoassociado.js'
			}
		},
		uglify: {
			painel: {
				src: 'js/painel.js',
				dest: 'js/painel.js'
			},
			site: {
				src: 'js/site.js',
				dest: 'js/site.js'
			},
			areadoassociado: {
				src: 'js/areadoassociado.js',
				dest: 'js/areadoassociado.js'
			}
		},
		cssmin: {
			painel: {
				src: 'css/painel.css',
				dest: 'css/painel.css'
			},
			site: {
				src: 'css/site.css',
				dest: 'css/site.css'
			},
			areadoassociado: {
				src: 'css/areadoassociado.css',
				dest: 'css/areadoassociado.css'
			}
		},
		stylus: {
			options: {
				compress: false
			},
			site: {
				src: ['css/dev/site/layout.styl'],
				dest: 'css/site.css'
			},
			painel: {
				src: ['css/dev/painel/layout.styl'],
				dest: 'css/painel.css'
			},
			areadoassociado: {
				src: ['css/dev/areadoassociado/layout.styl'],
				dest: 'css/areadoassociado.css'
			}
		},
		autoprefixer: {
			options: {
				browsers: ['last 2 versions', 'ie 8', 'ie 9']
			},
			site: {
				src: ['css/site.css'],
				dest: 'css/site.css'
			},
			painel: {
				src: ['css/painel.css'],
				dest: 'css/painel.css'
			},
			areadoassociado: {
				src: ['css/areadoassociado.css'],
				dest: 'css/areadoassociado.css'
			}
		},
		watch: {
			jssite: {
				files: ['js/dev/site/*.js'],
				tasks: ['devjssite'],
				options: {
					spawn: false
				}
			},
			jspainel: {
				files: ['js/dev/painel/*.js'],
				tasks: ['devjspainel'],
				options: {
					spawn: false
				}
			},
			jsgeral: {
				files: ['js/dev/geral/*.js'],
				tasks: ['devjsgeral'],
				options: {
					spawn: false
				}
			},
			jsareadoassociado: {
				files: ['js/dev/areadoassociado/*.js'],
				tasks: ['devjsareadoassociado'],
				options: {
					spawn: false
				}
			},
			csspainel: {
				files: ['css/dev/painel/*.styl'],
				tasks: ['devcsspainel'],
				options: {
					spawn: false
				}
			},
			csssite: {
				files: ['css/dev/site/*.styl'],
				tasks: ['devcsssite'],
				options: {
					spawn: false
				}
			},
			cssgeral: {
				files: ['css/dev/geral/*.styl'],
				tasks: ['devcssgeral'],
				options: {
					spawn: false
				}
			},
			cssareadoassociado: {
				files: ['css/dev/areadoassociado/*.styl'],
				tasks: ['devcssareadoassociado'],
				options: {
					spawn: false
				}
			}
		},
		phplint: {
			app: ["app/**/*.php"],
			config: [".config/**/*.php"],
			system: ["system/**/*.php"],
			index: ["index.php"]
		}
	});

	/**
	 * CARREGAMENTO DOS PLUGINS
	**/
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks("grunt-phplint");

	/**
	 * REGISTRO DAS TASK
	**/
	grunt.registerTask('default', []);
	grunt.registerTask('minify', ['uglify', 'stylus', 'cssmin', 'imagemin']);

	// PRODUCAO
	grunt.registerTask('producao', ['jshint', 'phplint', 'concat', 'uglify', 'stylus', 'autoprefixer', 'cssmin', 'imagemin', 'clean']);

	// DEV
	grunt.registerTask('dev', ['watch']);
	grunt.registerTask('devjssite', ['concat:site']);
	grunt.registerTask('devjspainel', ['concat:painel']);
	grunt.registerTask('devjsgeral', ['concat']);
	grunt.registerTask('devjsareadoassociado', ['concat:areadoassociado']);
	grunt.registerTask('devcsssite', ['stylus:site', 'autoprefixer:site']);
	grunt.registerTask('devcsspainel', ['stylus:painel', 'autoprefixer:painel']);
	grunt.registerTask('devcssareadoassociado', ['stylus:areadoassociado', 'autoprefixer:areadoassociado']);
	grunt.registerTask('devcssgeral', ['stylus', 'autoprefixer']);

};
