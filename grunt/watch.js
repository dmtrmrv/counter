module.exports = {
	styles: {
		files: [ 'assets/css/sass/*.scss', 'assets/css/sass/**/*.scss' ],
		tasks: [ 'css', 'clean', 'copy' ],
		options: {
			livereload: true
		}
	},
	scripts: {
		files: [ 'assets/js/*.js' ],
		tasks: [ 'clean', 'copy' ],
		options: {
			livereload: true
		}
	},
	php: {
		files: [ '**/*.php', '*.php' ],
		tasks: [ 'clean', 'copy' ],
		options: {
			livereload: true
		}
	},
	customizer: {
		files: [ 'assets/js/customizer-*.js', 'assets/css/customizer.css' ],
		tasks: [ 'clean', 'copy' ],
		options: {
			livereload: true
		}
	},
}
