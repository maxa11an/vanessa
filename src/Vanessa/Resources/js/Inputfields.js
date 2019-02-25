import {Vanessa} from "./Vanessa";
import jQuery from 'jquery';

export class Inputfields {
	constructor(){
		this.fields = templateFields;
		this.renderLoaded();
	}

	renderLoaded(){
		this.fields.forEach(Inputfields.renderItem);
	}

	static renderItem(item){
		console.log(item);
		const TYPE = `${Vanessa.capitalize(item.type)}Inputfield`;
		const element = jQuery(`[data-type="${TYPE}"]`).clone();
		jQuery(element).find('label').text(item.name);
		jQuery(element).find('input').val(item.default);
		jQuery(element).appendTo("#Inputfields");
	}
}