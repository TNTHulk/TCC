/*global angular, console*/
var app = angular.module('app', ['ngRoute']);
 
app.config(function ($routeProvider, $locationProvider) {
    // remove o # da url
    'use strict';
    $locationProvider.html5Mode(true);

    $routeProvider
        .when('/', {
            templateUrl : 'static/assets/js/app/views/home.html',
            controller     : 'HomeCtrl'
        })
    
        .when('/listarPredios', {
            templateUrl : 'static/assets/js/app/views/listarPredios.html',
            controller  : 'ListarPrediosCtrl'
        })
    
        .when('/editarPredio', {
            templateUrl : 'static/assets/js/app/views/editarPredio.html',
            controller  : 'ListarPrediosCtrl'
        })
    
        .when('/listarSalas', {
            templateUrl : 'static/assets/js/app/views/listarSalas.html',
            controller  : 'ListarSalasCtrl'
        })
    
        .when('/editarSala', {
            templateUrl : 'static/assets/js/app/views/editarSala.html',
            controller  : 'ListarSalasCtrl'
        })
    
        .when('/listarProfessores', {
            templateUrl : 'static/assets/js/app/views/listarProfessores.html',
            controller  : 'ListarProfessoresCtrl'
        })
    
        .when('/editarProfessor', {
            templateUrl : 'static/assets/js/app/views/editarProfessor.html',
            controller  : 'ListarProfessoresCtrl'
        })
    
        .when('/listarDisciplinas', {
            templateUrl : 'static/assets/js/app/views/listarDisciplinas.html',
            controller  : 'ListarDisciplinasCtrl'
        })
    
        .when('/editarDisciplina', {
            templateUrl : 'static/assets/js/app/views/editarDisciplina.html',
            controller  : 'ListarDisciplinasCtrl'
        })
    
      .when('/listarRestricoes', {
            templateUrl : 'static/assets/js/app/views/listarRestricoes.html',
            controller  : 'ListarRestricoesCtrl'
        })
    
        .when('/editarRestricaoProfessor', {
            templateUrl : 'static/assets/js/app/views/editarRestricaoProfessor.html',
            controller  : 'ListarRestricoesCtrl'
        })
    
        .when('/editarRestricaoSala', {
            templateUrl : 'static/assets/js/app/views/editarRestricaoSala.html',
            controller  : 'ListarRestricoesCtrl'
        })

    
        .when('/cadastrarSala', {
            templateUrl : 'static/assets/js/app/views/cadastroSala.html',
            controller  : 'CadastroSalaCtrl'
        })
    
        .when('/cadastrarRestricao', {
            templateUrl : 'static/assets/js/app/views/cadastroRestricao.html',
            controller  : 'CadastroSalaCtrl'
        })
    
        .when('/cadastrarProfessor', {
            templateUrl : 'static/assets/js/app/views/cadastroProfessor.html',
            controller  : 'CadastroProfessorCtrl'
        })
    
    
        .when('/editarAlocacao', {
            templateUrl : 'static/assets/js/app/views/editarAlocacao.html',
            controller  : 'CadastroAlocacaoCtrl'
        })
    
        .when('/listarAlocacoes', {
            templateUrl : 'static/assets/js/app/views/listarAlocacoes.html',
            controller  : 'ListarAlocacoesCtrl'
        })

        .when('/relatorios', {
            templateUrl : 'static/assets/js/app/views/relatorios.html',
            controller  : 'RelatoriosCtrl'
        })
            
        .when('/login', {
            templateUrl : 'static/assets/js/app/views/login.html',
            controller  : 'LoginCtrl'
        })
        
        .otherwise({
            redirectTo: '/'
        });
});