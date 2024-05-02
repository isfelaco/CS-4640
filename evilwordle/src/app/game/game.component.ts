import { Component } from '@angular/core';
import { ApiService } from '../api-service.service';
import { Observable, throwError } from 'rxjs';

@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrl: './game.component.css',
})
export class GameComponent {
  word!: string;
  guesses: {
    guess: string;
    correctLetters: number;
    correctPositions: number;
    length: string;
  }[] = [];
  alert: boolean = false;

  constructor(private apiService: ApiService) {
    this.initializeGame();
  }

  newGame(): void {
    this.initializeGame();
  }

  initializeGame(): void {
    this.apiService.fetchWord().subscribe(
      (res: string) => {
        this.word = res;
        console.log(this.word);
        this.guesses = [];
        console.log('Word fetched from API:', this.word);
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

    const regex: RegExp = /^[a-zA-Z]+$/;

    if (guess !== '' && regex.test(guess)) {
      this.alert = false;
      console.log(guess);

      const { correctLetters, correctPositions } = this.compareWords(
        this.word,
        guess
      );

      let lengthMessage: string = '';
      if (guess.length > this.word.length) lengthMessage = 'Too long';
      else if (guess.length < this.word.length) lengthMessage = 'Too short';
      else lengthMessage = 'Correct length';

      const guessData = {
        guess: guess,
        correctLetters: correctLetters,
        correctPositions: correctPositions,
        length: lengthMessage,
      };

      this.guesses.push(guessData);

      if (guess.toLowerCase() === this.word) {
        console.log('Game over! It took you ', this.guesses.length, ' guesses');
      }
    } else this.alert = true;
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
}
