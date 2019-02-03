@extends('system-mgmt.etudiant.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      
        <div class="container">
            <div class="row">
                <div class="form-group">
                  <strong>Id  : </strong>
                  {{$etudiant->id}}

                </div>
            </div>

            <div class="row">
                <div class="form-group">
                  <strong>Last Name :</strong>
                  {{$etudiant->lastname}}
                </div>
            </div>
            <div class="row">
              <div class="form-group">
                <strong>First Name :</strong>
                {{$etudiant->firstname}}
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <strong>MiddleName :</strong>
                {{$etudiant->middlename}}
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <strong>Addresse :</strong>
                {{$etudiant->address}}
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <strong>Zip :</strong>
                {{$etudiant->Zip}}
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <strong>Age :</strong>
                {{$etudiant->age}}
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <strong>BirthDate :</strong>
                {{$etudiant->birthdate}}
              </div>
            </div>
      

            <div class="row">
                  <a href="{{ route('home') }}" class="btn btn-primary" >Retour</a>
            </div>
        </div>

    </section>
 
@endsection