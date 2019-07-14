
 <?php if (isset($_SESSION['message_store'])) :;?>
    <div class="alert alert-<?= $_SESSION['message_store'][0] == true ? 'success' : 'danger'; ?>" role="alert">
        <?= $_SESSION['message_store'][1]; unset($_SESSION['message_store']);?>
    </div>
    <?php endif;?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-8">
			<form id="form" class="row justify-content-center" method="GET" action="<?= BASE_URL;?>studyplan/structure">
				<?php if (isset($data['typeCourse'])) :; ?>
					<input name="id" type="hidden" value='<?= $id ?>' />
					<input name="slug" type="hidden" value='<?= $data['typeCourse']['slug'] ?>' />
					<input name="slugUpdate" type="hidden" value='<?= $slug?>' />
					<input name="update" type="hidden" value="update" />
				<?php endif; ?>
				<div class="col-12 border p-2">
					<div class="text-center">
						<h1 class="cor-ifesp-1">Meu plano de estudos</h1>
					</div>
				</div>
				<div class="col-12 border p-2">
					<div>
						<label>Nome do tipo de curso</label>

						<input class="form-control" type="text" name="nameCourse" id="nomeCurso" value="<?= isset($data['typeCourse']) ? $data['typeCourse']['name']: '';?>"><br>
						
						<label>Número de etapas</label>
						<select class="form-control" name="steps">
						<?php for ($i = 1; $i <= 20; $i++):?>
							<option value="<?=$i?>" <?= isset($data['typeCourse']) && $data['typeCourse']['number_steps'] == $i ? "selected='selected'" : ''; ?> > <?= $i; ?> </option>
						<?php endfor;?>
						</select>
						<br/>
						<label>Número de grupo de atividades</label>
						<select class="form-control" name="groups">
							<?php for ($i = 1; $i <= 10; $i++):?>	
								<option value="<?=$i?>" <?= isset($data['typeCourse']) && $data['typeCourse']['number_groups'] == $i ? "selected='selected'" : ''; ?> > <?= $i; ?> </option>
							<?php endfor;?>
						</select>
					</div>
				</div>
				<div class="col-12 p-2">
					<button type="submit" class="btn btn-success day">GERAR</button>
				</div>
			</form>
		</div>
	</div>
	
</div>
