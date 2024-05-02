import { Injectable } from '@angular/core';
import {
  HttpClient,
  HttpErrorResponse,
  HttpParams,
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  constructor(private http: HttpClient) {}

  fetchWord(): Observable<string> {
    return this.http.get<string>('http://localhost:8080/hw8/wordle_api.php', {
      responseType: 'text' as 'json',
    });
  }
}
