<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-8">
			<div class="">
        <?php
          
        ?>
                <a href=<?=BASE_URL.'index.php?url=home/pageCadastro'?>><p>Cadastrar novo cliente</p></a>

                <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">nome</th>
      <th scope="col">telefone</th>
      <th scope="col">endereco</th>
    </tr>
  </thead>
  <tbody>
  
    
    <?php foreach($nome as $key => $value): ?>
    <tr>
      <th scope="row"><?=$key + 1?></th>
      <td><?=$value?></td>
      <td><?=$telefone[$key]?></td>
      <td><?=$endereco[$key]?></td>
    </tr>
    <?php endforeach; ?>
    
  </tbody>
</table>
                </div>
		</div>
	</div>
</div>

<script>


</script>
