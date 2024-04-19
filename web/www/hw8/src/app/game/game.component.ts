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

    const form = event.target as HTMLFormElement;
    const guessInput = form.elements.namedItem(
      'word-input'
    ) as HTMLInputElement;
    const guess = guessInput.value;
    console.log(guess);
    // const guess = targetElement.querySelector('input[name="word-input"]').value;
    // if (guess.value !== '') {
    //   console.log('Input value:', inputElement.value);
    // }
  }
}
