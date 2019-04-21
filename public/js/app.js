let paths = document.getElementById("paths").dataset;

APP_NAME = paths.name;
CSS_URL = paths.css;
JS_URL = paths.js;
URL = paths.root;

String.prototype.capitalise = () => {
	return this && this.charAt(0).toUpperCase() + this.slice(1);
}