
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <form id="form" class="row" method="POST" action="<?= $update ? BASE_URL.'index.php?url=studyplan/update' : BASE_URL.'index.php?url=studyplan/store'; ?>">
                <?php if ($update) :; ?>
                    <input type="hidden" name="_method" value="<?=$nameCourse?>">
                    <input type="hidden" name="slugUpdate" value="<?=$slugUpdate?>">
                    <input type="hidden" name="id" value="<?=$id?>">
                    
                <?php endif; ?>
                <div class="col-12 border p-2">
                    <div class="text-center">
                        <h1 class="cor-ifesp-1">Plano de estudos</h1>
                        <h5 class="text-uppercase"><?= rawurldecode($nameCourse); ?></h5>
                    </div>
                </div>
                <?php for ($step = 1; $step <= $steps; $step++) :; ?>
                    <div class="col-12">
                        <div class="row base">
                            <div class="col-8 mt-5">
                                <div>
                                    <input type="text" readonly class="form-control mb-3 w-50 time-load-field" class="form-control mb-3" value="ÈTAPE <?= $step; ?>" placeholder="ÈTAPE <?= $step; ?>">
                                </div>
                                <?php for ($group = 1; $group <= $groups; $group++) :; ?>
                                    <div class="d-flex">
                                        <span class="btn-delete mt-2 mr-2 d-block"><i class="fa fa-times-circle"></i></span>
                                        <input type="text" data-position="<?= ($step - 1) .'-'. ($group - 1); ?>" value="<?= $update && isset($groupValue[$step - 1][$group - 1]) && ($stepsSet == $steps) && ($groups == $groupsSet) ? $groupValue[$step - 1][$group - 1] : 'Gr. Atividades ' . $alphabet[($group - 1)]; ?>" class="form-control mb-3 group-field" data-field="<?= ($group - 1); ?>" placeholder="Gr. Atividades <?= $alphabet[($step - 1)]; ?>" name="groups[<?= $step;?>][]">
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="col-4 mt-2">
                                <p>CH</p>
                                <div class="form-row">
                                    <input type="text" value="" data-field="<?= ($group - 1); ?>"  readonly class="form-control mb-3 w-50 time-load-field">
                                </div>
                                <?php for ($group = 1; $group <= $groups; $group++) :; ?>
                                    <div class="form-row time-load " data-position="<?= ($step - 1) .'-'. ($group - 1); ?>">
                                        <input type="text" data-field="<?= ($group - 1); ?>" class="form-control mb-3 w-50 time-load-field time-load-field-dinamic" value="<?= $update && isset($stepValue[$step - 1][$group - 1]) && ($stepsSet == $steps) && ($groups == $groupsSet) ? $stepValue[$step - 1][$group - 1] : ''; ?>" name="timeLoads[<?= $step;?>][]">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($step === 1) :; ?>
                        <div>
                            <div class="col-12">
                                <div>
                                    <div class="ml-4 mr-2">
                                        <input type="checkbox" id="repeat">
                                    </div>
                                </div>
                                <p> Repetir grupos nas demais atividades </p>
                            </div>
                        </div>
                    <?php endif; ?>
            <?php endfor; ?>
                <div class="col-12 mt-3">
                    <input type="hidden" name="nameCourse" value="<?= $nameCourse; ?>">
                    <input type="hidden" name="groupQuantity" value="<?= $groups; ?>">
                    <input type="hidden" name="stepQuantity" value="<?= $steps; ?>">
                    <input class="btn btn-success" type="submit" value="ENVIAR">
                </div>
            </form>
            <p class="mt-2 mb-4">CARGA HORÁRIA TOTAL DO GRUPO: <span id="timeLoadTotal"></span></p>

        </div>
    </div>
</div>


<script>
    $(function() {

        //Verifica se está atualizando ou não as informações contidas no formulario
        let update = <?= $update ? 'true' : 'false'; ?>;

        function totalSpanFunction(called = false) {
            let totalSpan = [];

            $('.time-load-field-dinamic').each(function () {
                if (called) {
                    calculate($(this), true);
                }

                if ($.isNumeric($(this).val())) {
                    totalSpan.push($(this).val());
                }
            });
            
        
            if(minutes == null){
                            var minutes = 0;
                        }
                        if(hours == null){
                            var hours = 0;
                        }
                       
                        for(i = 0; i < totalSpan.length; i++){
                            numBreak = totalSpan[i].split(".");
                            hours += parseFloat(numBreak[0]);
                            if(numBreak[1] != null){
                            if(numBreak[1].length == 1){
                                minutes += parseFloat(numBreak[1]) * 10;
                            }else if(numBreak[1].length == 2){
                                minutes += parseFloat(numBreak[1]);
                            }
                             }
                            else {
                                minutes += 0;
                            }
                            
                        }
                        while(minutes >= 60){
                            minutes -= 60;
                            hours += 1;
                        }
                        console.log(hours)
                        console.log(minutes)

                 
          let totalHour = hours+'.'+minutes;

            // totalSpan = totalSpan.reduce((a,b) => parseFloat(a) + parseFloat(b), 0);

            $('#timeLoadTotal').text(totalHour);
        }

        function calculate(obj, called = false) {
            let inputValues = [];

            obj.parent().parent().children().each(function (index) {
                if (index > 1) {
                    //para não pegar a linha estática utilizei o index > 1 já que o 0 é o <p>
                    if ($.isNumeric($(this).find('input').val())) {
                        inputValues.push($(this).find('input').val());
                        // console.log(inputValues.length);
                //         
                // 
                    
                //     console.log(hours);
            
                //  console.log(minutes);
                }}
            });

               
            if(minutes == null){
                            var minutes = 0;
                        }
                        if(hours == null){
                            var hours = 0;
                        }
                        
                        for(i = 0; i < inputValues.length; i++){
                            numBreak = inputValues[i].split(".");
                            hours += parseFloat(numBreak[0]);
                            if(numBreak[1] != null){
                            if(numBreak[1].length == 1){
                                minutes += parseFloat(numBreak[1]) * 10;
                            }else if(numBreak[1].length == 2){
                                minutes += parseFloat(numBreak[1]);
                            }
                            }else{
                                minutes += 0;
                            } 
                        }
                        while(minutes >= 60){
                            minutes -= 60;
                            hours += 1;
                        }
                        
                       

                 
          let total = hours+'.'+minutes;

            // let total = inputValues.reduce((a,b) => parseFloat(a) + parseFloat(b), 0);
            obj.parent().parent().children().eq(1).find('input').val(total);

            if (! called) {
                totalSpanFunction(false);
            }
        }

        //INICIO DA FUNÇÃO QUE SETA OS VALORES DA PRIMEIRA ETAPA NAS DEMAIS.
        function repeatValuesToSteps(field) {
            let divBase = $('.base');//div raiz das etapas.

            let firstStep = [];//let por que preciso que fique restrito apenas ao escopo deste bloco if

            divBase.eq(0).children().eq(field === 'groups' ? 0 : 1).children().each(function (index) {//pera pegar os valores
                if (index > 0) {//para index maior que 0 eu ignoro a linha stática
                    let findField = field === 'groups' ?
                        ".group-field[data-field='" :
                        ".time-load-field[data-field='";

                    let fieldValue = $(findField + (index - 1) +"']")
                        .val();
                    //precisei subtratir 1 do indice por que subtraí do data-field
                    firstStep.push(fieldValue);
                }
            });

            divBase.each(function (indexBase) {
                if (indexBase > 0) {
                    $(this).children().eq(field === 'groups' ? 0 : 1).children().each(function (index) {//pera pegar os valores
                        if (index > 0) {//para index maior que 0 eu ignoro a linha stática

                            let findField = field === 'groups' ?
                                ".group-field[data-field='" :
                                ".time-load-field[data-field='";

                            $(findField+ (index - 1) +"']")
                                .val(firstStep[index - 1]);
                            //precisei subtratir 1 do indice por que subtraí do data-field
                        }
                    });
                }
            });
        }
        //FIM DA FUNÇÃO QUE SETA OS VALORES DA PRIMEIRA ETAPAS NAS DEMAIS

        if (update) {
            totalSpanFunction(true);
        }

        //INICIO DO EVENTO DE DELETAR UM GRUPO
        $('.btn-delete').on('click', function () {
            //pego a posição da linha para excluir e passo como parametro do time-load que quero excluir
            $(".time-load[data-position='" + $(this)
                .next().data('position') +"']").remove();
            //agora excluo o próprio grupo
            $(this).parent().remove();
        });
        //FIM DO EVENTO DE DELETAR UM GRUPO

        //INICIO DO EVENTO DE SETAR VALORES DA PRIMEIRA ETAPA PARA AS DEMAIS
        $("#repeat").on('change', function() {//verifico se o checkbox de repetir valores está checkado
            if ($(this).is(':checked')) {
                //chamo a função criada lá no topo do script e passo o tipo de campo que eu quero setar os valores.
                repeatValuesToSteps('groups');
                repeatValuesToSteps('timeLoads');
                $('.time-load-field-dinamic').trigger('keyup');//para poder recalcular o total.
            }
        });
        //FIM DO EVENTO DE SETAR VALORES DA PRIMEIRA ETAPA PARA AS DEMAIS

        //INICIO DO EVENTO QUE SOMA OS VALORES DAS CARGAS HORARIAS
        $('.time-load-field-dinamic').on('keyup', function () {
            calculate($(this), false);
        });

        //FIM DO EVENTO QUE SOMA OS VALORES DAS CARGAS HORARIAS

    });
</script>
