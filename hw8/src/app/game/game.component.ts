import { Component } from '@angular/core';
import {
  HttpClient,
  HttpErrorResponse,
  HttpParams,
} from '@angular/common/http';

@Component({
  selector: 'app-game',
  standalone: true,
  templateUrl: './game.component.html',
  styleUrl: './game.component.css',
})
export class GameComponent {
  word: string;
  guesses: string[];

  constructor(private http: HttpClient) {
    // get word from wordle_api.php
    this.word = '';
    this.fetchWordFromApi();
    console.log(this.word);

    this.guesses = [];
  }

  fetchWordFromApi(): void {
    this.http
      .get<any>('http://localhost:8080/hw8/wordle_api.php', {})
      .subscribe(
        (res) => {
          this.word = res.word;
        },
        (error) => {
          console.error('Error fetching word from API:', error);
        }
      );
  }

  guessWord(event: Event): void {
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

      if (guess.toLowerCase() === this.word) {
        console.log('Game over! It took you ', this.guesses.length, ' guesses');
      }
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

  updateGuesses(): void {
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
      let lengthMessage: string = '';
      if (guess.length > word.length) lengthMessage = 'Too long';
      else if (guess.length < word.length) lengthMessage = 'Too short';
      else lengthMessage = 'Correct length';
      length.textContent = lengthMessage;
      row.appendChild(length);

      table?.appendChild(row);
    });
  }
}
