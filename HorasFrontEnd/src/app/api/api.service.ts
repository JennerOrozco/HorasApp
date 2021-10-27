import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  private URL = "http://localhost/api/req/"

  constructor() { }

  async registerUser(data) {
    let url = this.URL + "carritos/create.php"
    let response = await fetch(url, {
      method: "POST",
      body: JSON.stringify({
        carro: data.nombres,
        moto: data.nombres,
        lancha: data.nombres,
        camion: data.nombres,
        avion: data.nombres
      })
    })

    if (response.status == 200) {
      
      let jsonResponse = await response.json()
      return jsonResponse
    }

  }
}
