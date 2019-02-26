import {Vanessa} from "./Vanessa";
import {Inputfields} from "./Inputfields";
import jQuery from 'jquery';


new Vanessa();

if(jQuery("#Inputfields").length > 0){
	const inputFields = new Inputfields();
	inputFields.renderLoaded();
}

jQuery('.modal').on('show.bs.modal', function (e) {
	jQuery('.modal .modal-dialog').attr('class', 'modal-dialog  zoomIn  animated vanessa-animated');
});
jQuery('.modal').on('hide.bs.modal', function (e) {
	jQuery('.modal .modal-dialog').attr('class', 'modal-dialog  zoomOut  animated vanessa-animated');
});