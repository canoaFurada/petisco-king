<?php

class studyplanController extends Controller
{

    public function index()
    {
        $this->loadTemplate('type_course_one');
    }

    /**
     * Estrutura do plano
     *
     * Este método mostra a view para criação de uma estrutura de curso
     * seus valores são submetidos do metodo index desta mesma classe.
     *
     */
    public function structure()
    { // armazena os valores dos inputs pra setar no banco

        $data = array();
        //pega a quantidade de grupos para montar a view

        $data['groups'] = isset($_GET['groups']) ? $_GET['groups'] : 2;
        //pega a quantidade de etapas para montar a view
        $data['steps'] = isset($_GET['steps']) ? $_GET['steps'] : 2;
        //pega o nome do curso para colocar na view
        $data['nameCourse'] = isset($_GET['nameCourse']) ? $_GET['nameCourse'] : "Curso Básico";
        //pega as letras do alfabeto para montar os grupos
        $data['alphabet'] = range('A', 'Z');

        //se vier name update significa que estou editando
        $data['update'] = isset($_GET['update']) ? true : false;

        $data['structure'] = isset($_GET['structure']) ? $_GET['structure'] : false;
        $data['slug'] = isset($_GET['slug']) ? $_GET['slug'] : false;

        
        

        if ($data['slug'] !== false) {
            $typeCourse = new TypeCourse();
            $typeCourse = $typeCourse->getBySlug($data['slug']);

            $data['id'] = $_GET['id'];
            $data['typeCourse'] = $typeCourse['typeCourse'];
            $data['studyPlans'] = $typeCourse['studyPlans'];

            //preciso converter de string para json para melhorar
            $structure = $data['studyPlans']['structure'];
            $structure = json_decode($structure);

            $data['structure'] = $structure;
            $data['stepsSet'] = $_GET['steps'];
            $data['groupsSet'] = $_GET['groups'];
            $data['steps'] = $data['typeCourse']['number_steps'];

            $data['groups'] = $data['typeCourse']['number_groups'];

            $data['stepValue'] = array_slice($data['structure'][0], $data['steps']);
            $data['groupValue'] = array_slice($data['structure'][0], 0, ($data['groups']));
            $data['slugUpdate'] = $_GET['slugUpdate'];
        }

        $this->loadTemplate('type_course_two', $data);
    }

    /**
     * Armazena informações do curso
     *
     * Este método realiza o insert no banco nas tabelas type_coursers e study_plans
     * depois disso redireciona com a mensagem se deu certo ou não.
     *
     */
    public function store()
    { // armazena os valores dos inputs pra setar no banco
        //TODO fazer a validação para checar se todos valores foram setados.






        $groups = $_POST['groups'];
        $timeLoads = $_POST['timeLoads'];
        $nameCourse = $_POST['nameCourse'];
        $groupQuantity = $_POST['groupQuantity'];
        $stepQuantity = $_POST['stepQuantity'];
        $json = array();
        array_push($json, array_merge($groups, $timeLoads));
        $structure = json_encode($json, JSON_PRETTY_PRINT);



        if ($nameCourse == null) {
            $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
            $this->loadTemplate('type_course_one');
            exit;
        }

        foreach ($groups as $value) {
            foreach ($value as $val) {
                if ($val == null) {
                    $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
                    $this->loadTemplate('type_course_one');
                    exit;
                }
            }
        }

        foreach ($timeLoads as $key => $value) {
            foreach ($value as $val) {
                if ($val == null) {
                    $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
                    $this->loadTemplate('type_course_one');
                    exit;
                }

                if (!is_numeric($val)) {

                    $_SESSION['message_store'] = [false, "Você deve inserir um número na carga horária"];;
                    $this->loadTemplate('type_course_one');
                    exit;
                }
               
                $value = array();

                $value = explode('.', $val);
                if(strlen($value[1]) == 1){
                    $value[1] = $value[1].'0';
                };
              
                if($value[1] > 59){
                    
                    $_SESSION['message_store'] = [false, "Você não pode inserir mais do que 59 minutos na carga horária"];;
                    $this->loadTemplate('type_course_one');
                    exit;
                }
              
                
                 
              

                
                
            }
            
        }

        
        $slug = $this->createSlug($nameCourse);

        $typeCourse = new TypeCourse();
        $verifySlug = $typeCourse->getBySlugVerify($slug);
        if ($verifySlug != null) {
            $_SESSION['message_store'] = [false, "Este curso já foi criado"];;
            $this->loadTemplate('type_course_one');
            exit;
        }

        $inserted = $typeCourse->store(
            $nameCourse,
            $groupQuantity,
            $stepQuantity,
            $structure,
            $slug
        );

        //TODO fazer retornar com mensagem de sucesso ou erro.
        if ($inserted) {
            //success
            $_SESSION['message_store'] = [true, "Item criado com sucesso!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        } else {
            //failed
            $_SESSION['message_store'] = [false, "Houve um problema ao criar o item!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        }
        $this->loadTemplate('type_course_one');
    }

    /**
     * Criar um slug
     *
     * Este método gera um slug a partir da string passada como parametro.
     * Retorna uma string formatada como slug para URLs
     *
     */
    private function createSlug($str, $delimiter = '-')
    {

        $slug = strtolower(
            trim(
                preg_replace(
                    '/[\s-]+/',
                    $delimiter,
                    preg_replace(
                        '/[^A-Za-z0-9-]+/',
                        $delimiter,
                        preg_replace(
                            '/[&]/',
                            'and',
                            preg_replace(
                                '/[\']/',
                                '',
                                iconv('UTF-8', 'ASCII//TRANSLIT', $str)
                            )
                        )
                    )
                ),
                $delimiter
            )
        );
        return $slug;
    }

    /**
     * Listagem de Tipos de Cursos
     *
     * Este método busca do banco os cursos criados e lista suas informações em uma tabela na view,
     * permitindo a edição e exclusão das informações.
     *
     */
    public function list()
    { // pega os valores do banco pra setar na pagina de edição/exclusão
     
        $array = array();

        $typeCourse = new TypeCourse();

        $typeCourses = $typeCourse->get();

        $array['typeCoursers'] = $typeCourses;

        $this->loadTemplate('home', $array);
    }

    /**
     * Deleta tipos de cursos
     *
     * Este método busca do banco o curso desejado e seta o valor do status para false,
     * dessa forma fazendo uma exclusão suave do registro no banco, por questões de segurança.
     *
     */
    public function delete($id)
    { // vai no banco e "deleta" a row desejada

        $typeCourse = new TypeCourse();

        $deleted = $typeCourse->softDelete($id);

        //TODO fazer retornar com mensagem de sucesso ou erro.
        if ($deleted) {
            //success
            $_SESSION['message_store'] = [true, "Item removido com sucesso!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        } else {
            //failed
            $_SESSION['message_store'] = [false, "Houve um problema ao remover o item!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        }
    }

    public function edit($slug)
    { //te direciona pra a pagina de ediçao com as informaçoes do banco do item desejado

        $array = array();

        $typeCourse = new TypeCourse();

        $array['data'] = $typeCourse->getBySlug($slug);
        $array['slug'] = $slug;
        $array['id'] = $array['data']['typeCourse']['id'];


        $this->loadTemplate('type_course_one', $array);
    }

    public function update()
    {
        $name = $_POST['nameCourse'];
        $id = $_POST['id'];
        $groups = $_POST['groups'];
        $timeLoads = $_POST['timeLoads'];
        $slug = $_POST['slugUpdate'];
        $numberSteps = $_POST['stepQuantity'];
        $numberGroups = $_POST['groupQuantity'];
        $array = array();

        $typeCourse = new TypeCourse();

        $array['data'] = $typeCourse->getBySlug($slug);
        $array['slug'] = $slug;
        $array['id'] = $array['data']['typeCourse']['id'];
        $typeCourse = new TypeCourse();
        $verify = $typeCourse->getBySlugEdit($slug, $id);

        foreach ($verify as $key => $value) {
            if($key == 1){
            if ($slug == $verify[1][0]) {

                if ($verify[1][1] != $id) {

                    $_SESSION['message_store'] = [false, "Já existe um curso com esse nome"];;
                    
                    $this->loadTemplate('type_course_one', $array);
                    exit;
                }
            }
            }
        }
        if ($slug == $verify[0][0]) {

            if ($verify[0][1] != $id) {

                $_SESSION['message_store'] = [false, "Já existe um curso com esse nome"];;
                $this->loadTemplate('type_course_one', $array);
                exit;
            }
        }

        if ($name == null) {
            $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
            $this->loadTemplate('type_course_one', $array);
            exit;
        }

        foreach ($groups as $value) {
            foreach ($value as $val) {
                if ($val == null) {
                    $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
                    $this->loadTemplate('type_course_one', $array);
                    exit;
                }
            }
        }

        foreach ($timeLoads as $value) {
            foreach ($value as $val) {
                if ($val == null) {
                    $_SESSION['message_store'] = [false, "Você deve preencher todos os campos"];;
                    $this->loadTemplate('type_course_one', $array);
                    exit;
                }

                if (!is_numeric($val)) {

                    $_SESSION['message_store'] = [false, "Você deve inserir um número na carga horária"];;
                    $this->loadTemplate('type_course_one', $array);
                    exit;
                }
                $value = array();

                $value = explode('.', $val);
                if(strlen($value[1]) == 1){
                    $value[1] = $value[1].'0';
                };
              
                if($value[1] > 59){
                                        
                    $_SESSION['message_store'] = [false, "Você não pode inserir mais do que 59 minutos na carga horária"];;
                    $this->loadTemplate('type_course_one');
                    exit;
                }
            }
        }
        





        $typeCourse = new TypeCourse();
        $newSlug = $this->createSlug($name);

        $json = array();
        foreach($timeLoads as $key => $value){
            foreach($value as $key2 => $val){
                $numberBroak = explode('.', $val);
                if(strlen($numberBroak[1]) == 1){
                    $val = $numberBroak[0].'.'.$numberBroak[1].'0';
                    $timeLoads[$key][$key2] = $val; 
                    
                    
                };
                
            }    
        }
        
       
        array_push($json, array_merge($groups, $timeLoads));
        $structure = json_encode($json, JSON_PRETTY_PRINT);

        $update = $typeCourse->softUpdate($name, $slug, $newSlug, $numberSteps, $numberGroups, $structure);

        if ($update) {
            //success
            $_SESSION['message_store'] = [true, "Item atualizado com sucesso!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        } else {
            //failed
            $_SESSION['message_store'] = [false, "Houve um problema ao atualizar o item!"];
            header("location: " . BASE_URL . "/studyplan/list");
            exit;
        }
        $this->loadTemplate('type_course_one');
    }
}
