import {Vanessa} from "./Vanessa";
import jQuery from 'jquery';

export class Inputfields {
	constructor(){
		this.fields = templateFields;

	}

	renderLoaded(){
		registerEvents();
		this.fields.forEach(async (i) => {
			await this.renderItem(i)
		});
		checkFirstAndLast();
	}

	renderItem(item){
		return new Promise((resolve) => {
			const TYPE = `${Vanessa.capitalize(item.type)}Inputfield`;
			const element = jQuery(`#InputfieldTypes > [data-type="${TYPE}"]`).clone(true, true);
			jQuery(element).find('label').text(item.name);
			jQuery(element).find('input').val(item.default);
			jQuery(element).appendTo("#Inputfields");
			resolve();
		})

	}


}


function registerEvents(){

	jQuery("#InputfieldTypes > .item .clickable").on("click", function() {
		const element = jQuery(this);
		if(element.hasClass('disabled')) return;
		if(element.hasClass('item-action-up')){
			moveItem(element, `-`);
		}else if(element.hasClass('item-action-down')){
			moveItem(element, `+`);
		}else if(element.hasClass('item-action-remove')){
			deleteItem(element);
		}
		//return moveRow($(this), `-` );
	});

	jQuery("#FieldOptions [data-action='add']").on("click", function(){
		const type = jQuery(this).data('type');
		addNewItem(type);
		return false;
	})

	/*jQuery(container).on("click", ".item-action-down:not(.disabled)", () => {
		return moveRow($(this), `+` );
	})*/
}

function moveItem(item, step){

	const currentElement = item.parents('div.item');
	if(step === `-`){
		currentElement.insertBefore(currentElement.prev());
	}else{
		currentElement.insertAfter(currentElement.next());
	}
	currentElement.addClass("moved");
	setTimeout(function(){
		currentElement.removeClass("moved").dequeue();
		checkFirstAndLast();
	}, 300);

	return false;
}

function deleteItem(item){
	const currentElement = item.parents('div.item');
	currentElement.addClass("animated vanessa-animated fadeOutLeft");
	setTimeout(function(){
		currentElement.remove();
		checkFirstAndLast();
	}, 300);
}

function addNewItem(type){
	const currentElement = jQuery(`#InputfieldTypes > [data-type="${type}"]`).clone(true, true);
	currentElement.addClass('animated vanessa-animated fadeInLeft');
	currentElement.appendTo("#Inputfields");
	setTimeout(function(){
		currentElement.removeClass('animated vanessa-animated fadeInLeft');
		checkFirstAndLast();
	}, 300);

	const p = jQuery('#Inputfields').parents('.editor');
	p.animate({scrollTop: p.prop("scrollHeight")}, 300, () => {
		jQuery(`.modal[data-type="${type}"]`).modal('show')
	});
}


function checkFirstAndLast() {
	const elements = jQuery("#Inputfields").find('.item');
	jQuery.each(elements, (index, item) => {
		item = jQuery(item);
		console.log("Index", index);
		item.find('.item-action-down, .item-action-up').removeClass('disabled');
		if(index === 0) {
			item.find('.item-action-up').addClass('disabled')
		}
		if(index + 1 === elements.length ){
			item.find('.item-action-down').addClass('disabled');
		}
	})
}