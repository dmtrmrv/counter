module.exports = {
	default: {
		src: [
			'./*.php',
			'./templates/*.php',
			'./template-parts/*.php',
			'./inc/*.php',
			'./inc/**/*.php',
			'./style.css',
			'./style-rtl.css',
			'./assets/css/*.css',
			'./assets/js/*.js',
			'./assets/fonts/font-awesome/fonts/**',
			'./assets/fonts/font-awesome/css/font-awesome.css',
			'./assets/img/*.jpg',
			'./languages/<%= package.name %>.pot',
			'./languages/readme.txt',
			'./README.txt',
			'./screenshot.png',
			'./codesniffer.ruleset.xml'
		],
		dest: '../build/<%= package.name %>',
		expand: true
	},
	rtl: {
		src: './rtl/style.css',
		dest: './style-rtl.css'
	}
};
