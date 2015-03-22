<?php

  $routes->get('/', function() {
    //HelloWorldController::index();
    BlogiController::etusivu();
  });

  $routes->get('/postaus', function() {
    BlogiController::postaus();
  });

  $routes->get('/postaus/muokkaa', function() {
	  BlogiController::postaus_muokkaus();
  });

  $routes->get('/listaus', function() {
	  BlogiController::listaus();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/prujulistaus', function() {
    HelloWorldController::prujulistaus();
  });

  $routes->get('/edit', function() {
    HelloWorldController::edit();
  });

  $routes->post('/signup', function() {
    KayttajaController::register();
  });

  $routes->get('/signup', function() {
    KayttajaController::signup();
  });

  $routes->get('/kokeilu', function() {
		BlogiController::showkokeilu();
	});

  $routes->get('/blogi/:nimi', function($nimi) {
    BlogiController::show($nimi);
  });
