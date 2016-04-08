@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>Система управления</h1>
        <h1>электронной очередью "Ласточка"</h1>
        <p>Записаться на приём</p>
    </div>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Терминалы</h2>
          <p>Выбор терминала для данного устройства</p>
          <p><a class="btn btn-default" href="#" role="button">Выбрать &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Панели</h2>
          <p>Выбор панели для данного устройства. </p>
          <p><a class="btn btn-default" href="#" role="button">Выбрать &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Операторы</h2>
          <p>Выбрать оператора для данного устройства.</p>
          <p><a class="btn btn-default" href="#" role="button">Выбрать &raquo;</a></p>
        </div>
      </div>
    </div>
</div>
@endsection
