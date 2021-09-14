import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-register-form',
  templateUrl: './register-form.component.html',
  styleUrls: ['./register-form.component.scss'],
})
export class RegisterFormComponent implements OnInit {
  registerForm: FormGroup;

  constructor(private modalCtrl: ModalController, private frmBld: FormBuilder) {
    this.registerForm = this.frmBld.group({
      nombres: new FormControl("", Validators.compose([
        Validators.required,
        Validators.minLength(3),
      ])),
      apellidos: new FormControl("", Validators.compose([
        Validators.required,
        Validators.minLength(3),
      ])),
      correo: new FormControl("", Validators.compose([
        Validators.required,
        Validators.email,
      ]))
    })

  }

  ngOnInit() { }

  async dismissModal() {
    await this.modalCtrl.dismiss();
  }

  registerUser(formValues) {
    console.log(formValues)
  }

}
