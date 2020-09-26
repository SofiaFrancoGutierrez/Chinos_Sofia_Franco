<!--Heredar master page-->
@extends('layouts.masterpage')

    <!--Definiendo el contenido-->
    @section('contenido')
    <form class="form-horizontal" method="POST" action="{{  url('mediatypes/store')    }}" enctype="multipart/form-data">
    @csrf
        <fieldset>
        
        <!-- Form Name -->
        <legend>Form Name</legend>
        
        <!-- File Button --> 
        <div class="form-group">
          <label class="col-md-4 control-label" for="media-types">Elegir un archivo</label>
          <div class="col-md-4">
            <input id="media-types" name="media-types" class="input-file" type="file">
            <strong class="text-danger">{{   $errors->first('media-types')   }}</strong>
          </div>
        </div>
        
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"></label>
          <div class="col-md-4">
            <button type="submit" id="" name="singlebutton" class="btn btn-primary">Enviar</button>
          </div>
        </div>
        
        </fieldset>
        <!--
            Mensaje de exito
        -->
        @if(session('exito'))
        <p class="alert-success">{{ session('exito') }}</p>
        @endif
        @if (session('repetidos'))
          @foreach (session('repetidos') as $mediarepetido)
            <p class="alert-warming">{{ $mediarepetido }}</p>
          @endforeach            
        @endif
        </form>
        @endsection
