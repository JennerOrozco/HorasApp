import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { RegisterFormComponent } from '../modals/registerForm/register-form.component';

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  constructor(private modalCtrl: ModalController) { }

  ngOnInit() {
  }

  async showModal() {
    const modal = await this.modalCtrl.create({
      component: RegisterFormComponent
    })
    await modal.present();
  }

}
