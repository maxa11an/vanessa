import jQuery from 'jquery';
import bootstrap from 'bootstrap';
import notify from 'bootstrap4-notify';

/**
 * Vanessa Class
 */
export class Vanessa {
	constructor() {
		this.flashes();
	}

	flashes(){
		Object.keys(slimFlashes).forEach((type) => {
			slimFlashes[type].forEach((flash) => {
				jQuery.notify({
					message: flash
				}, {
					type: type,
					placement: {
						from: "bottom",
						align: "right"
					},
					animate: {
						enter: 'animated fadeInUp',
						exit: 'animated fadeOutDown'
					}
				})
			})
		})
	}

	static capitalize(string) {
		return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
	}



}