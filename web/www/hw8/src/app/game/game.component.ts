import { Component } from '@angular/core';

@Component({
  selector: 'app-game',
  standalone: true,
  imports: [],
  templateUrl: './game.component.html',
  styleUrl: './game.component.css',
})
export class GameComponent {
  word: string;
  guesses: string[];

  constructor() {
    // get word from wordle_api.php
    this.word = 'hello';

    this.guesses = [];
  }

  guessWord(event: Event) {
    event.preventDefault();

    const form = event.target as HTMLFormElement;
    const guessInput = form.elements.namedItem(
      'word-input'
    ) as HTMLInputElement;
    const guess = guessInput.value;

    if (guess !== '') {
      console.log(guess);
      this.guesses.push(guess);
      this.updateGuesses();
    }
  }

  compareWords(
    word: string,
    guess: string
  ): { correctLetters: number; correctPositions: number } {
    let correctLetters = 0;
    let correctPositions = 0;

    const length = Math.min(word.length, guess.length);

    for (let i = 0; i < length; i++) {
      const wordLetter = word[i];
      const guessLetter = guess[i];

      if (wordLetter === guessLetter) {
        correctLetters++;
        correctPositions++;
      } else {
        if (word.includes(guessLetter)) {
          correctLetters++;
        }
      }
    }

    return { correctLetters, correctPositions };
  }

  updateGuesses() {
    const guesses: string[] = this.guesses;
    const word: string = this.word;
    const table: HTMLElement | null = document.getElementById('guesses-table');
    if (table) table.innerHTML = '';

    guesses.forEach((guess, index) => {
      const { correctLetters, correctPositions } = this.compareWords(
        word,
        guess
      );

      var row: HTMLTableRowElement = document.createElement('tr');

      var num: HTMLTableCellElement = document.createElement('th');
      num.scope = 'row';
      num.textContent = (index + 1).toString();
      row.appendChild(num);

      var guessWord: HTMLTableCellElement = document.createElement('td');
      guessWord.textContent = guess.toLowerCase();
      row.appendChild(guessWord);

      var numInWord: HTMLTableCellElement = document.createElement('td');
      numInWord.textContent = correctLetters.toString();
      row.appendChild(numInWord);

      var numCorrect: HTMLTableCellElement = document.createElement('td');
      numCorrect.textContent = correctPositions.toString();
      row.appendChild(numCorrect);

      var length = document.createElement('td');
      length.textContent =
        guess.length > word.length ? 'Too long' : 'Too short';
      row.appendChild(length);

      table?.appendChild(row);
    });
  }
}
