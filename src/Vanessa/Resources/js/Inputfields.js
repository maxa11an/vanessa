import {Vanessa} from "./Vanessa";
import jQuery from 'jquery';

export class Inputfields {
	constructor() {
		this.fields = templateFields;
	}

	renderLoaded() {
		jQuery("#Inputfields, #FieldOptions").hide();
		registerEvents();
		this.fields.forEach(async (i) => {
			await this.renderItem(i)
		});
		checkFirstAndLast();
		jQuery("#Inputfields, #FieldOptions").fadeIn(200);
	}

	renderItem(item) {
		return new Promise((resolve) => {
			const refElement = jQuery(`#InputfieldTypes > [data-type="${Vanessa.capitalize(item.type)}Inputfield"]`);
			const currentElement = refElement.clone(true, true);
			jQuery(currentElement).appendTo("#Inputfields");
			jQuery(currentElement).find('textarea').val(JSON.stringify(item)); //Not most nice way to store data, altho it works
			renderItemFromOptions(currentElement, item);
			resolve();
		})

	}
}

function renderItemFromOptions(currentElement, options = []) {
	currentElement.attr('data-name', options.name);
	Object.keys(options).forEach((option) => {
		const value = options[option];
		const source = currentElement.find(`[data-ref-${option}]`);
		if (source.is(':input[type!="checkbox"][type!="radio"]')) {
			source.val(value)
		} else if(source.is(':input[type="checkbox"]')) {
			if(`${value}` === `true`){
				source.prop("checked", "checked")
			}
		} else {
			source.text(value)
		}
	})
}

function registerEvents() {

	jQuery("#InputfieldTypes > .item .clickable").on("click", function () {
		const element = jQuery(this);
		if (element.hasClass('disabled')) return;
		if (element.hasClass('item-action-up')) {
			moveItem(element, `-`);
		} else if (element.hasClass('item-action-down')) {
			moveItem(element, `+`);
		} else if (element.hasClass('item-action-remove')) {
			deleteItem(element);
		} else if (element.hasClass('item-action-settings')) {
			editItem(element);
		}
		//return moveRow($(this), `-` );
	});

	jQuery("#FieldOptions [data-action='add']").on("click", function () {
		const type = jQuery(this).data('type');
		addNewItem(type);
		return false;
	});

	/**
	 * Pre-fill name of a newly created field
	 */
	jQuery("#InputfieldConfig input[vanessa-label-name]").on("blur", function () {
		const el = jQuery(this);
		let value = el.val().trim();
		const target = el.parents('form').find('input[name="name"]');
		const newValue = value.toLocaleLowerCase().replace(/[^\w\s]/g, "").replace(/[\s]/g, "_");

		//Name field is empty
		if (target.val() === "") {
			target.val(newValue);
			return;
		}
	});

	/**
	 * Check so that the field's name is unique and not a safe word
	 */
	jQuery("#InputfieldConfig input[vanessa-name-unique]").on("keydown", function (e) {
		if (e.keyCode === 32) {
			e.preventDefault();
			const newChar = "_";
			const position = this.selectionStart;
			this.value = [this.value.slice(0, position), newChar, this.value.slice(position)].join('');
			this.selectionEnd = position+1;
		}
	});
	jQuery("#InputfieldConfig input[vanessa-name-unique]").on("change keyup", function () {
		const el = jQuery(this);
		const value = el.val().trim();
		el.val(value.toLocaleLowerCase().replace(/[^\w\s]/g, "").replace(/[\s]/g, "_"));
		if (value !== "" && (jQuery(`#Inputfields .item[data-name="${value}"]`).length !== 0 || value.indexOf(['title']) !== -1) ) {
			el.next().show();
		} else {
			el.next().hide();
		}
		return;
	})

	/*jQuery(container).on("click", ".item-action-down:not(.disabled)", () => {
		return moveRow($(this), `+` );
	})*/
}

function moveItem(item, step) {

	const currentElement = item.parents('div.item');
	if (step === `-`) {
		currentElement.insertBefore(currentElement.prev());
	} else {
		currentElement.insertAfter(currentElement.next());
	}
	currentElement.addClass("moved");
	setTimeout(function () {
		currentElement.removeClass("moved").dequeue();
		checkFirstAndLast();
	}, 300);

	return false;
}

function deleteItem(item) {
	const currentElement = item.parents('div.item');
	currentElement.addClass("animated vanessa-animated fadeOutLeft");
	setTimeout(function () {
		currentElement.remove();
		checkFirstAndLast();
	}, 300);
}

function editItem(item) {
	const currentElement = item.parents('div.item');
	const type = currentElement.data('type');
	const optionsHolder = currentElement.find('textarea');
	const options = JSON.parse(optionsHolder.val() || "{}");
	jQuery(`.modal[data-type="${type}"]`).modal('show').one('shown.bs.modal', (e) => {
		jQuery(e.currentTarget).find('form :input:eq(0)').focus();
		jQuery(e.currentTarget).find('form[vanessa-field-settings]').one("submit", function(f) {
			f.preventDefault();
			const form = jQuery(this);
			let newOptions = {};
			form.serializeArray().forEach((m) => {
				newOptions[m.name] = m.value;
			});
			newOptions = Object.assign({}, options, newOptions);
			optionsHolder.val(JSON.stringify(newOptions));
			form[0].reset();
			jQuery(`.modal[data-type="${type}"]`).modal('hide');
			renderItemFromOptions(currentElement, newOptions);
		})
	});
	const form = jQuery(`.modal[data-type="${type}"]`).find('form');
	Object.keys(options).forEach((optionName) => {
		form.find(`[name="${optionName}"]`).val(options[optionName]);
	});
}

function addNewItem(type) {
	const refElement = jQuery(`#InputfieldTypes > [data-type="${type}"]`);
	const currentElement = refElement.clone(true, true);

	currentElement.addClass('animated vanessa-animated fadeInLeft');
	currentElement.appendTo("#Inputfields");
	setTimeout(function () {
		currentElement.removeClass('animated vanessa-animated fadeInLeft');
		checkFirstAndLast();
	}, 300);

	const p = jQuery('#Inputfields').parents('.editor');
	p.animate({scrollTop: p.prop("scrollHeight")}, 300, () => {
		currentElement.find('.item-action-settings').click();
	});
}


function checkFirstAndLast() {
	const elements = jQuery("#Inputfields").find('.item');
	jQuery.each(elements, (index, item) => {
		item = jQuery(item);
		console.log("Index", index);
		item.find('.item-action-down, .item-action-up').removeClass('disabled');
		if (index === 0) {
			item.find('.item-action-up').addClass('disabled')
		}
		if (index + 1 === elements.length) {
			item.find('.item-action-down').addClass('disabled');
		}
	})
}