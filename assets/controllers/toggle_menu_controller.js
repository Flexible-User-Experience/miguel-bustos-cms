import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["menu", "iconList", "iconX"];

    connect() {
        // En connect, assegurem que la icona inicial és la de la llista i la "X" està amagada.
        // Això és opcional si les classes ja estan definides a l'HTML.
    }

    toggle() {
        this.menuTarget.classList.toggle('hidden');
        this.iconListTarget.classList.toggle('hidden');
        this.iconXTarget.classList.toggle('hidden');
    }
}