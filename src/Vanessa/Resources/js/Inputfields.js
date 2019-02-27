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
			jQuery(element).find('textarea').val(JSON.stringify(item)); //Not most nice way to store data, altho it works
			jQuery(element).appendTo("#Inputfields");
			renderItemFromOptions(element);
			resolve();
		})

	}
}

function renderItemFromOptions(currentElement){
	const options = JSON.parse(jQuery(currentElement).find('textarea').val());
	Object.keys(options).forEach((option) => {
		const value = options[option];
		const source = currentElement.find(`[data-ref-${option}]`);
		if(source.is('input') || source.is('select')){
			source.val(value)
		}else{
			source.text(value)
		}
	})
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
		}else if(element.hasClass('item-action-settings')){
			editItem(element);
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

function editItem(item){
	const currentElement = item.parents('div.item');
	const type = currentElement.data('type');
	const optionsHolder = currentElement.find('textarea');
	const options = JSON.parse(optionsHolder.val());
	jQuery(`.modal[data-type="${type}"]`).modal('show').one("hidden.bs.modal", (e) => {
		console.log(jQuery(e.currentTarget).find('form').serializeArray());
		let newOptions = {};
		jQuery(e.currentTarget).find('form').serializeArray().forEach((m) => {
			newOptions[m.name] = m.value;
		});
		optionsHolder.val(JSON.stringify(Object.assign({}, options, newOptions )));
		renderItemFromOptions(currentElement);
	});
	const form = jQuery(`.modal[data-type="${type}"]`).find('form');
	Object.keys(options).forEach((optionName) => {
		form.find(`[name="${optionName}"]`).val(options[optionName]);
	});
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