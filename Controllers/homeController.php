<?php

class homeController extends Controller
{ public function pageCadastro()
    
    {
        
 
       
        var_dump("SAHZAM");
        die;
    }

    public function index()
    { // pega os valores do banco pra setar na pagina de edição/exclusão
        
        $array = array();

        $typeCourse = new TypeCourse();

        $typeCourses = $typeCourse->get();

        $array['typeCoursers'] = $typeCourses;
        
        $this->loadTemplate('home', $array);
    }
}
