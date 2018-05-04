
	<div class="container ml-0 mt-4 py-3 px-3">
		<div class="row row-eq-height">
			<div class="col-12 col-md-12">
				<h2><i class="icon d-inline-table"><img class="d-none d-md-block" src="<?php echo ltm_banners_url . '/assets/img/favicon-16x16.png'?>" /></i> LTM - Sistema de Banners</h2>
			</div>
		</div>
	</div>
	<div class="container ml-0 bg-white py-3 px-3">
		
		<?php
		$banners = array();
		if ($_GET['task'] == 'ltm_edit') {
				global $wpdb;
				$banners = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ltm_banners WHERE group_id='". $_GET['i'] ."'", OBJECT );
				$group_id = $b->group_id;
				$name = $banners[0]->name;
		}
		?>
		<div class="row">
			<div class="col-12 col-md-12 pb-4 text-center text-md-left">
				<h4>Informações</h4>
			</div>
			<div class="col-12 col-md-12 newBanner">
				<form method="post" action="<?php menu_page_url( 'ltm_page_banner', true ); ?>" >
					<?php
					parse_str($_SERVER['QUERY_STRING'], $query_string);
					foreach ($query_string as $k=>$qs) {
						echo "<input type='hidden' name='". $k ."' value='". $qs ."' />";
					}
					?>
					<div class="form-group">
						<label for="bannerName">Nome do Banner</label>
						<input value="<?php echo isset($name) ? $name : "" ?>" type="text" required="true" class="form-control" name="bannerName" id="bannerName" placeholder="Qual o nome do banner?">
						<small id="bannerName" class="form-text text-muted">Essa informação não será mostrada para o usuário.</small>
					</div>

					<div class="form-group">
						<h4>Imagens</h4>
					</div>
					<!-- usado de modelo -->
					<div class="form-group imagem d-none px-2 py-2" data-index="0">
						<div class="row row-eq-height">
							<div class="col-12 col-md-7">
								<div class="row">
									<div class="col-12 col-md-6 text-left px-3 py-3">
										<div class="row">
											<div class="col-12 mb-3 text-left">
												<a href="" class="btn btn-sm btn-danger removeItem">Apagar a Linha</a>
											</div>
											<div class="col-12 mb-2">
												<label>Início: <input required="true" type="text" class="form-control data_inicio datepicker" name="data_inicio[0]" placeholder="data" value="<?php echo date('d/m/Y') ?>"></label>
											</div>
											<div class="col-6">
												<label>Horário: </label>
												<select class="form-control hora_inicio"  name="hora_inicio[0]" >
													<?php for ($a=0; $a < 24; $a++) { ?>
														<option <?php echo date('H') == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
															<?php echo $a ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-6">
												<label>&nbsp;</label>
												<select class="form-control minuto_inicio"  name="minuto_inicio[0]" >
													<?php for ($a=0; $a < 60; $a++) { ?>
														<option <?php echo date('m') == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
															<?php echo str_pad($a, 2, "0", STR_PAD_LEFT); ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-12">
												<small id="timezone" class="form-text text-muted">Horário do servidor: <strong><?php echo date("H:i:s") ?></strong></small>
											</div>
										</div>					
									</div>
									<div class="col-12 col-md-6 text-left px-3 py-3">
										
							
									
										<div class="row">
											<div class="col-12 mb-3 text-left">
												&nbsp;
											</div>
											
											<div class="col-12 mb-2">
												<label>Final: <input type="text" required="true"  class="form-control data_final datepicker" name="data_final[0]" placeholder="data" value="<?php echo date('d/m/Y', strtotime("+1 year")) ?>"></label>
											</div>
											<div class="col-6">
												<label>Horário: </label>
												<select class="form-control hora_final"  name="hora_final[0]" >
													<?php for ($a=0; $a < 24; $a++) { ?>
														<option <?php echo date('H') == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
															<?php echo $a ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-6">
												<label>&nbsp;</label>
												<select class="form-control minuto_final"  name="minuto_final[0]" >
													<?php for ($a=0; $a < 60; $a++) { ?>
														<option <?php echo date('m') == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
															<?php echo str_pad($a, 2, "0", STR_PAD_LEFT); ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>					
									</div>
									<div class="col-12 text-left px-3 py-3">
										<label class="w-100">Link: <input required="true" type="text" class="form-control link w-100" name="link[0]" placeholder="URL de destino" value="#"></label>				
									</div>
								</div>
							</div>
							<div class="col-12 col-md-5 border">
								<div class="item row mb-4 py-3">
								</div>
							</div>
						</div>
					</div>
					<!-- usado de modelo -->
					<?php
					$edicao = 1;
					if (count($banners) > 0) {
						foreach ($banners as $b) {
							
							$start_date = $b->start_date;
							$start = strtotime($start_date);
							$start_date = date("d/m/Y", $start);
							$start_hour = date("H", $start);
							$start_minute = date("i", $start);
							
							$end_date = $b->end_date;
							$end = strtotime($end_date);
							$end_date = date("d/m/Y", $end);
							$end_hour = date("H", $end);
							$end_minute = date("i", $end);
							
							$image = $b->image;
							$banner_id = $b->id; 
							
							$link = $b->link; 
							
							require(ltm_banners_dir . "inc/item.php");
							$edicao++;
						}
					} else {
						require(ltm_banners_dir . "inc/item.php");
					}
					?>
					<div class="row">
						<div class="col-12 text-left">
							<a href="#" class="btn btn-secondary addItem">Adicionar Novo</a>
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<script src="<?php echo ltm_banners_url.'assets/js/ltm-banner.js?t=' . date('his') ?>"></script>
