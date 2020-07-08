import datepicker from 'air-datepicker';
import Inputmask from "maskedinput";
import lightbox from "lightbox2";
import uiplaceholder from './block/ui-placeholder';

var counter = 0;
var mask = new Inputmask('+7 (999) 999 99-99');
if (document.querySelector('.maskedinput-js')) {
	mask.mask(document.querySelector('.maskedinput-js'));
}

import './include/init-swiper';