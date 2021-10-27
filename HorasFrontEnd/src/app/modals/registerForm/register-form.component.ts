import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { LoadingController, ModalController } from '@ionic/angular';
import { ApiService } from 'src/app/api/api.service';

@Component({
  selector: 'app-register-form',
  templateUrl: './register-form.component.html',
  styleUrls: ['./register-form.component.scss'],
})
export class RegisterFormComponent implements OnInit {
  registerForm: FormGroup;
  loading;

  constructor(private modalCtrl: ModalController, private frmBld: FormBuilder, private callApi: ApiService, public loadingController: LoadingController) {
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

  async registerUser(formValues) {
    this.presentLoading()
    let apiResponse = await this.callApi.registerUser(formValues);
    this.dismissLoading()
    this.dismissModal()
  }

  async presentLoading() {
    this.loading = await this.loadingController.create({
      message: 'Please wait...'
    });
    await this.loading.present();
  }

  async dismissLoading() {
    await this.loading.dismiss()
  }



}
