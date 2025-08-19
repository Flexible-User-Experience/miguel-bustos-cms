import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ 'menu', 'iconList', 'iconX' ];

    toggle() {
        this.menuTarget.classList.toggle('hidden');
        this.iconListTarget.classList.toggle('hidden');
        this.iconXTarget.classList.toggle('hidden');
    }
}
