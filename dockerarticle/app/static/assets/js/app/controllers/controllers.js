/*global app*/
app.controller('ListarPrediosCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/predios').success(function (data) {
        $rootScope.predios = data;
    });
    
    $rootScope.editarPredio = function (predio) {
        $rootScope.predio = predio;
        $location.path('/editarPredio');
    };

    $rootScope.excluirPredio = function (id) {
        $http.delete('/api/predios/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/predios').success(function (data) {
            $rootScope.predios = data;
        });
    };
});

app.controller('ListarSalasCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/salas').success(function (data) {
        $rootScope.salas = data;
    });
    
    $rootScope.editarSala = function (sala) {
        $rootScope.sala = sala;
        $http.get('api/predios').success(function (data) {
            $rootScope.predios = data;
        });
        $location.path('/editarSala');
    };

    $rootScope.excluirSala = function (id) {
        $http.delete('/api/salas/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/salas').success(function (data) {
            $rootScope.salas = data;
        });
    };
});

app.controller('ListarProfessoresCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/professores').success(function (data) {
        $rootScope.professores = data;
    });
    
     $rootScope.editarProfessor = function (professor) {
        $rootScope.professor = professor;
        $location.path('/editarProfessor');
    };

    $rootScope.excluirProfessor = function (id) {
        $http.delete('/api/professores/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/professores').success(function (data) {
            $rootScope.professores = data;
        });
    };
});

app.controller('ListarDisciplinasCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/disciplinas').success(function (data) {
        $rootScope.disciplinas = data;
    });
    
    $rootScope.editarDisciplina = function (disciplina) {
         $rootScope.disciplina = disciplina;
         $location.path('/editarDisciplina/');
    };

    $rootScope.excluirDisciplina = function (codigo_disciplina) {
        $http.delete('/api/disciplinas/' + codigo_disciplina, { codigo_disciplina: codigo_disciplina }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/disciplinas').success(function (data) {
            $rootScope.disciplinas = data;
        });
    };
});



app.controller('ListarRestricoesCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/restricoesProfessores').success(function (data) {
        $rootScope.restricoesProfessores = data;
    });
    
    $http.get('api/restricoesSalas').success(function (data) {
        $rootScope.restricoesSalas = data;
    });
    
    
    $rootScope.editarRestricaoSala = function (restricaoSala) {
         $rootScope.restricaoSala = restricaoSala;
         $location.path('/editarRestricaoSala/');
         $http.get('api/salas').success(function (data) {
         $rootScope.salas = data;
         if(restricaoSala != null){
            $rootScope.isDisabled = true;   
         }else{
            $rootScope.isDisabled = false;    
         }  
    });
        
    
    $rootScope.selectedItem ={"id":restricaoSala.idsala};
        
    };
    
    
     $rootScope.editarRestricaoProfessor = function (restricaoProfessor) {
         $rootScope.restricaoProfessor = restricaoProfessor;
         $location.path('/editarRestricaoProfessor/');
         $http.get('api/professores').success(function (data) {
         $rootScope.professores = data;
         if(restricaoProfessor != null){
            $rootScope.isDisabled = true;   
         }else{
            $rootScope.isDisabled = false;    
         }
             
    });
        
    
    $rootScope.selectedItem ={"id":restricaoProfessor.idprofessor};
        
    };

    $rootScope.excluirRestricaoProfessor = function (id) {
        $http.delete('/api/restricoesProfessores/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/restricoesProfessores').success(function (data) {
            $rootScope.restricoesProfessores = data;
        });
    };
    
    $rootScope.excluirRestricaoSala = function (id) {
        $http.delete('/api/restricoesSalas/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/restricoesSalas').success(function (data) {
            $rootScope.restricoesSalas = data;
        });
    };
    
    
});

//---------- ALOCACOES --------------------------------------------------------------------
app.controller('ListarAlocacoesCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
    
    $http.get('api/alocacoes').success(function (data) {
        $rootScope.alocacoes = data;
    });
    $http.get('api/disciplinas').success(function (data) {
        $rootScope.disciplinas = data;
    });
    $http.get('api/professores').success(function (data) {
        $rootScope.professores = data;
    });
    $http.get('api/salas').success(function (data) {
        $rootScope.salas = data;
    });
    $http.get('api/predios').success(function (data) {
        $rootScope.predios = data;
    });
    
    $rootScope.editarAlocacao = function (alocacao) {
         $rootScope.alocacao = alocacao;
         $location.path('/editarAlocacao');
        if (alocacao != null){
            $rootScope.selectedPredio = alocacao.id_sala;
            $rootScope.selectedSala = alocacao.id_sala;
            $rootScope.selectedProfessor = alocacao.id_professor;
            $rootScope.selectedDisciplina = alocacao.id_disciplina;
        }
             
         $http.get('api/alocacoes').success(function (data) {
            $rootScope.alocacoes = data;
         });
    };
    
     $rootScope.excluirAlocacao = function (id) {
        $http.delete('/api/alocacoes/' + id, { id: id }).
            success(function (data, status, headers, config) {
                
            }).
            error(function (data, status, headers, config) {
            
            });
        $http.get('api/alocacoes').success(function (data) {
            $rootScope.alocacoes = data;
        });
    };
        
        

});


app.controller('CadastrosCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = $location.path();
});

app.controller('CadastroSalaCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
});

app.controller('CadastroProfessorCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
});

app.controller('CadastroDisciplinaCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
});

app.controller('CadastroAlocacaoCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = '/cadastros';
});
 
app.controller('RelatoriosCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = $location.path();
    $rootScope.gerarRelatorio = function (idpredio,idsala) {
           
        $http.get('api/gerarRelatorio/' +idpredio+'/'+idsala).success(function (data) {
            $rootScope.alocacoes = data;
        });
    };
    
    $http.get('api/alocacoes').success(function (data) {
        $rootScope.alocacoes = data;
    });
    
    $http.get('api/salas').success(function (data) {
        $rootScope.salas = data;
    });
    
    $http.get('api/predios').success(function (data) {
        $rootScope.predios = data;
    });
    $rootScope.selectedSala = 0;
    $rootScope.selectedPredio = 0;
});

app.controller('LoginCtrl', function ($rootScope, $location) {
    'use strict';
    $rootScope.activemenu = $location.path();
});

app.controller('HomeCtrl', function ($rootScope, $location, $http) {
    'use strict';
    $rootScope.activemenu = '/';
    
    $rootScope.alocacoes = null;
    
    $http.get('api/disciplinas').success(function (data) {
        $rootScope.disciplinas = data;
    });
    
    $http.get('api/professores').success(function (data) {
        $rootScope.professores = data;
    });
    
    $rootScope.buscarProfessor = function (id) {
        $http.get('api/buscarProfessor/' + id).success(function (data) {
            $rootScope.alocacoes = data;
        });
    };
    
    $rootScope.buscarDisciplina = function (id) {
        $http.get('api/buscarDisciplina/' + id).success(function (data) {
            $rootScope.alocacoes = data;
        });
    };
    $rootScope.selectedProfessor  = 0;
    $rootScope.selectedDisciplina = 0;
    
});



function getByKey(key,  data) {
    var found = null;

    for (var i = 0; i < data.length; i++) {
        var element = data[i];

        if (element.Key == key) {
           found = element;
       } 
    }

    return found;
}