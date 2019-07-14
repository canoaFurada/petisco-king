<?php

header("Content-type: text/html; charset=utf-8");

class TypeCourse extends Model
{
    public function get() // pega do banco os valores e armazena em $array
    {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM type_courses WHERE status = 1;");
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchall();
        }

        return $array;
    }


    public function getBySlugVerify($slug) //pega os valores do banco e armazena em $array a partir do slug
    {
       
        $array = array();
        $sql = $this->db->prepare("SELECT slug FROM type_courses WHERE slug = :slug LIMIT 1;");
        $sql->bindValue(":slug", $slug);
        $sql->execute();

        if ($sql->rowCount() > 0) {
                
            $verifySlug = $sql->fetch();
            
            return $verifySlug;
        }
    
} 

public function getBySlugEdit($slug, $id) //pega os valores do banco e armazena em $array a partir do slug
    {
       
        $array = array();
        $sql = $this->db->prepare("SELECT slug, id FROM type_courses WHERE slug = :slug;");
        $sql->bindValue(":slug", $slug);
        
        $sql->execute();

        if ($sql->rowCount() > 0) {
                
            $verifyAll = $sql->fetchall();
        
            return $verifyAll;
        }
    
}


    public function getBySlug($slug) //pega os valores do banco e armazena em $array a partir do slug
    {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM type_courses WHERE slug = :slug LIMIT 1;");
        $sql->bindValue(":slug", $slug);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $array['typeCourse'] = $sql->fetch();
            $id = $array['typeCourse']['id'];
            $sql = $this->db->prepare("SELECT structure FROM study_plans WHERE type_course_id = :id LIMIT 1;");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $array['studyPlans'] = $sql->fetch();
            }
        }

        return $array;
    }

    public function store($nameCourse, $groupQuantity, $stepQuantity, $structure, $slug){
        //insert nas tabelas type_coursers e study_plans
        try {
            $this->db->beginTransaction();//inicia a transaction no banco
            $nameCourse = rawurldecode($nameCourse);
            $now = date('Y-m-d H:i');
            
            

            $sql = $this->db->prepare("INSERT INTO type_courses
                    SET name = :name, number_steps = :stepQuantity, number_groups = :groupQuantity, type = '1',
                    slug = :slug, status = '1', created_at = :createdAt, updated_at = :updatedAt;");
            $sql->bindValue(':name', $nameCourse);
            $sql->bindValue(':stepQuantity', $stepQuantity);
            $sql->bindValue(':groupQuantity', $groupQuantity);
            $sql->bindValue(':slug', $slug);
            $sql->bindValue(':createdAt', $now);
            $sql->bindValue(':updatedAt', $now);
            $result = $sql->execute();

            if ($result) {//se for inserido com sucesso eu pego o id para referenciar na outra tabela.
                $typeCourseId = $this->db->lastInsertId();//pega o id do type_course inserido

                $sql = $this->db->prepare("INSERT INTO study_plans 
                        SET type_course_id = :typeCourseId, structure = :structure, slug = :slug,
                        status = '1', created_at = :createdAt, updated_at = :updatedAt");
                $sql->bindValue(':typeCourseId', $typeCourseId);
                $sql->bindValue(':structure', $structure);
                $sql->bindValue(':slug', $slug);
                $sql->bindValue(':createdAt', $now);
                $sql->bindValue(':updatedAt', $now);
                $result = $sql->execute();
                if ($result) {
                    $this->db->commit();//tudo certo, pode salvar tudo no banco
                    return true;
                }
            }
        } catch (Exception $exception) {
            $this->db->rollBack();//descarta as alterações no banco
            var_dump($exception);
            die;
        }

        $this->db->rollBack();//descarta as alterações no banco
        return false;
    }

    public function softDelete($id)//"deleta" do banco a row desejada
    {
        //delete nas tabelas type_coursers e study_plans
        try {
            $this->db->beginTransaction();//inicia a transaction no banco

            $sql = $this->db->prepare("UPDATE study_plans SET status = '0' WHERE type_course_id = :id;");
            $sql->bindValue(":id", $id);
            $result = $sql->execute();
                
                   
            if ($result) {//se for deletado com sucesso eu pego o id para deletar na outra tabela.
                $sql = $this->db->prepare("UPDATE type_courses SET status = '0' WHERE id= :id");
                $sql->bindValue(":id", $id);
                $result = $sql->execute();

                if ($result) {
                    $this->db->commit();//tudo certo, pode salvar tudo no banco
                    return true;
                }
            }
        } catch (Exception $exception) {
            $this->db->rollBack();//descarta as alterações no banco
            var_dump($exception);
            die;
        }

        $this->db->rollBack();//descarta as alterações no banco
        return false;
    }

    
    

    public function editone($id) //edita no banco a row desejada
    {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM type_courses WHERE id = :id LIMIT 1;");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();

        }
        return $array;
    }


    public function softUpdate($name, $slug, $newSlug, $numberSteps, $numberGroups, $structure)
    {    $name = rawurldecode($name);
        
        $updated = date('Y-m-d H:i');
        $sql = $this->db->prepare("UPDATE type_courses SET name = :name, slug = :newSlug, updated_at = :updated, number_steps = :numberSteps, number_groups = :numberGroups WHERE slug = :slug");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":newSlug", $newSlug);
        $sql->bindValue(":slug", $slug);
        $sql->bindValue(":updated", $updated);
        $sql->bindValue(":numberSteps", $numberSteps);
        $sql->bindValue(":numberGroups", $numberGroups);
        $sql->execute();
        
        $sql = $this->db->prepare("UPDATE study_plans SET structure = :structure, slug = :newSlug, updated_at = :updated WHERE slug = :slug;");
        $sql->bindValue(":newSlug", $newSlug);
        $sql->bindValue(":structure", $structure);
        $sql->bindValue(":slug", $slug);
        $sql->bindValue(":updated", $updated);
        
        $result = $sql->execute();
        
        if ($result) {
            
            return true;
    }

    }
}