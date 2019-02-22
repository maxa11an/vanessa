module.exports = function (grunt) {
	const sass = require('node-sass');

	grunt.initConfig({
		concat: {
			options: {
				separator: ';'
			},
			vanessaDeps: {
				src: [
					'node_modules/jquery/dist/jquery.js',
					'node_modules/popper.js/esm/dist/popper.js',
					'node_modules/bootstrap/dist/js/bootstrap.js',
				],
				dest: 'public_html/assets/admin/lib.js'
			},
			vanessa: {
				src: [
					'src/front-end/admin/assets/js/**/*.js'
				],
				dest: 'public_html/assets/admin/vanessa.js'
			}
		},
		uglify: {
			vanessaDeps: {
				files: {
					'public_html/assets/admin/lib.min.js': ['public_html/assets/admin/lib.js']
				}
			},
			vanessa: {
				files: {
					'public_html/assets/admin/vanessa.min.js': ['public_html/assets/admin/vanessa.js'],
				}
			}
		},
		jshint: {
			files: ['Gruntfile.js', 'src/front-end/admin/assets/js/**/*.js'],
			options: {
				// options here to override JSHint defaults
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},
		sass: {
			options: {
				implementation: sass,
				sourceMap: false
			},
			dist: {
				files: {
					'public_html/assets/admin/vanessa.css': 'src/front-end/admin/assets/scss/vanessa.scss'
				}
			}
		},
		cssmin: {
			options: {
				mergeIntoShorthands: false,
				roundingPrecision: -1,
				specialComments: 0
			},
			target: {
				files: {
					'public_html/assets/admin/vanessa.min.css': ['public_html/assets/admin/vanessa.css']
				}
			}
		},
		watch: {
			js:{
				files: ['<%= jshint.files %>'],
				tasks: ['jshint', 'concat:vanessa', 'uglify:vanessa']
			},
			sass:{
				files: ['src/front-end/admin/assets/scss/vanessa.scss'],
				tasks: ['sass', 'cssmin']
			}

		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');


	//grunt.registerTask('admin', ['jshint', 'concat:lib', 'uglify:lib', 'concat:vanessa', 'uglify:vanessa']);
	grunt.registerTask('adminDev', ['jshint', 'concat', 'uglify', 'sass', 'cssmin', 'watch'])

};