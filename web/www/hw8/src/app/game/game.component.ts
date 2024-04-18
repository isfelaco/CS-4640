import { Component } from '@angular/core';

@Component({
  selector: 'app-game',
  standalone: true,
  imports: [],
  templateUrl: './game.component.html',
  styleUrl: './game.component.css',
})
export class GameComponent {
  constructor() {}

  guessWord(event: Event) {
    event.preventDefault();

    const targetElement = event.target as HTMLFormElement;

    // const guess = targetElement.querySelector('input[name="word-input"]').value;
    // if (guess.value !== '') {
    //   console.log('Input value:', inputElement.value);
    // }
  }
}
