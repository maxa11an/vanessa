const path = require('path');
const devMode = false;

module.exports = {
	entry: ['./src/Vanessa/Resources/js/app.js'],
	output: {
		filename: 'vanessa.js',
		path: path.resolve(__dirname, "public_html/vanessa/assets")
	}
};