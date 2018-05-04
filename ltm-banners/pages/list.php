
	<div class="container ml-0 mt-4 py-3 px-3">
		<div class="row row-eq-height">
			<div class="col-12 col-md-12">
				<h2><i class="icon d-inline-table"><img class="d-none d-md-block" src="<?php echo ltm_banners_url . '/assets/img/favicon-16x16.png'?>" /></i> LTM - Sistema de Banners</h2>
			</div>
		</div>
	</div>
	<div class="container ml-0 bg-white py-3 px-3">
		
		<?php
		global $wpdb;
		$banners = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ltm_banners GROUP BY group_id", OBJECT );
		if (!$banners) {
			unset($banners);
		}
		?>
		<div class="row">
			<div class="col-6 col-md-10 pb-4 text-center text-md-left">
				<h4>Banners</h4>
			</div>
			<div class="col-6 col-md-2 pb-4 text-center text-md-right">
				<a class="btn btn-primary" href="<?php menu_page_url( 'ltm_page_banner', true ); ?>&task=ltm_add">Adicionar</a>
			</div>
			<div class="col-12 col-md-12">
				<?php
				if (isset($banners)) {
					?>
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th scope="col">Nome</th>
						  <th class="w-25 text-center">#</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						foreach($banners as $k=>$b) {
							?>
						<tr>
						  <td scope="row"><?php echo $b->name ?></td>
						  <td class="w-25 text-center">
							<a href="<?php menu_page_url( 'ltm_page_banner', true ); ?>&task=ltm_edit&i=<?php echo $b->group_id ?>" class="btn btn-secondary btn-sm">Editar</a>
							<a data-href="<?php menu_page_url( 'ltm_page_banner', true ); ?>&task=ltm_delete&i=<?php echo $b->group_id ?>" href="#" class="btn btn-danger btn-sm apagar">Apagar</a>
						  </td>
						</tr>
						<?php } ?>
					  </tbody>
					</table>
					<?php
				} else {
					?>
						<p>Não existem banners cadastrados.</p>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="apagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Apagar Banner</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Tem certeza que deseja apagar?</p>
		  </div>
		  <div class="modal-footer">
			<a href="#" class="btn btn-primary confirmar">Sim</a>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
		  </div>
		</div>
	  </div>
	</div>
	<script src="<?php echo ltm_banners_url.'assets/js/bootstrap.min.js' ?>"></script>
	<script src="<?php echo ltm_banners_url.'assets/js/ltm-banner.js' ?>?t=<?php echo date('his') ?>"></script>