import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  bandera = false;
  constructor() { }

  ngOnInit() {
  }


  show() {
    this.bandera = true;
  }

  noShow() {
    this.bandera = false;
  }


}
