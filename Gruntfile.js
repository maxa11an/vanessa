module.exports = function (grunt) {
	const sass = require('node-sass');

	grunt.initConfig({

		sass: {
			options: {
				implementation: sass,
				sourceMap: false
			},
			dist: {
				files: {
					'public_html/vanessa/assets/vanessa.css': 'src/Vanessa/Resources/scss/vanessa.scss'
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
					'public_html/vanessa/assets/vanessa.min.css': ['src/Vanessa/Resources/scss/vanessa.css']
				}
			}
		},
		copy: {
			dist: {
				files: [{
					expand: true,
					dot: true,
					cwd: 'src/Vanessa/Resources/assets/',
					dest: 'public_html/vanessa/assets/',
					src: [
						'**/*',
					]
				}]
			}
		},
		exec:{
			php: "composer dump-autoload"
		},
		watch: {
			sass:{
				files: ['src/Vanessa/Resources/scss/*.scss'],
				tasks: ['sass', 'cssmin']
			},
			assets:{
				files: ['src/Vanessa/Resources/**/*'],
				tasks: ['copy']
			},
			php: {
				files: ['src/Vanessa/**/*.php'],
				tasks: ['exec:php'],
				options: ['added', 'deleted']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-exec');

	grunt.registerTask('watch:dev', ['sass', 'cssmin', 'copy', 'watch'])

};