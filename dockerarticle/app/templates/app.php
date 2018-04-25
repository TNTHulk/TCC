<!DOCTYPE html>
<html ng-app="app">
    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SisRSA - Sistema para reserva de salas de aula</title>
        <link rel="stylesheet" href="../static/assets/css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../static/assets/css/style.css" />
        <script src="../static/assets/js/jquery/jquery-2.1.1.js"></script>
        <script src="../static/assets/js/bootstrap/bootstrap.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <nav class="navbar navbar-default my-navbar" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-principal">
                            <span class="sr-only">Navegação</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/">SisRSA</a>
                    </div>
                    <div class="collapse navbar-collapse" id="menu-principal">
                        <ul class="nav navbar-nav">
                            <li ng-class="{active: activemenu == '/'}">
                                <a href="home" ><span class="glyphicon glyphicon-home" aria-hidden="true" ></span> Home</a></li>
                            <li ng-class="{active: activemenu == '/cadastros'}">
                               <ul class="nav navbar-nav">
                                <li>
                                    <li class="dropdown" ng-class="{active: activemenu == '/cadastros'}">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Cadastrar <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="/listarPredios" >Prédio</a>
                                            </li>
                                            <li>
                                                <a href="/listarSalas" >Sala</a>
                                            </li>
                                            <li>
                                                <a href="/listarProfessores" >Professor</a>
                                            </li>
                                            <li>
                                                <a href="/listarDisciplinas" >Disciplina</a>
                                            </li>
                                            <li>
                                                <a href="/listarRestricoes" >Restrição</a>
                                            </li>                                            
                                            <li class="divider"></li>
                                            <li>
                                                <a href="/listarAlocacoes" >Alocaçao</a>
                                            </li>
                                        </ul>
                                    </li>
                                </li>
                            </ul>
                            <li ng-class="{active: activemenu == '/relatorios'}">
                                <a href="relatorios"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Relatórios</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <span class="glyphicon glyphicon-user"></span>( <?php echo strtoupper($usuario); ?> ) <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="login" target="_self"><span class="glyphicon glyphicon-retweet"></span> Trocar de usuário</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="/logout/" target="_self"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
                                        </li>
                                    </ul>
                                </li>
                            </li>
                        </ul>                    
                    </div>
                </div>
            </nav>
            <div class="error"></span></div>
            <div class="container-fluid">
                <div ng-view>
                    <!-- - - - - - - - - - - - - - - - View controlada pelo Angular - - - - - - - - - - - - - - - -->
                </div>
            </div>
            <div class="push"></div>
        </div>        

        <footer class="footer">  
            <nav id="menu-inferior" class="navbar navbar-default my-navbar" role="navigation">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">SisRSA</a>
                </div>
            </nav>               
        </footer>
        <script src="../static/assets/js/angular/angular.js"></script>
        <script src="../static/assets/js/angular/angular-route.js"></script>
        <script src="../static/assets/js/app/app.js"></script>
        <script src="../static/assets/js/app/controllers/controllers.js"></script>

    </body>
</html>