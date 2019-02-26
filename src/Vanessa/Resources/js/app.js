import {Vanessa} from "./Vanessa";
import {Inputfields} from "./Inputfields";
import jQuery from 'jquery';


new Vanessa();

if(jQuery("#Inputfields").length > 0){
	new Inputfields();
}