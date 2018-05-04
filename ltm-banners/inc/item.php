<div class="form-group imagem px-2 py-2" data-index="<?php echo $edicao ?>">
	<div class="row row-eq-height">
		<div class="col-12 col-md-7">
			<div class="row">
				<div class="col-12 col-md-6 text-left  px-3 py-3">
					<div class="row">
						<div class="col-12 mb-3 text-left">
							<?php echo $edicao > 1 ? '<a href="#" class="btn btn-sm btn-danger removeItem">Apagar a Linha</a>' : "&nbsp;" ?>
							<?php
							if (isset($banner_id)) {
								echo '<input type="hidden" name="banner_id['. $edicao .']" value="' . $banner_id .'">';			}
								
							?>
						</div>
						<div class="col-12 mb-2">
							<label class="w-100">Início: <input type="text" class="form-control data_inicio datepicker" name="data_inicio[<?php echo $edicao ?>]" placeholder="data" value="<?php echo isset($start_date) ? $start_date : date("d/m/Y") ?>"></label>
						</div>
						<div class="col-6">
							<label>Horário: </label>
							<select class="form-control hora_inicio"  name="hora_inicio[<?php echo $edicao ?>]" >
								<?php for ($a=0; $a < 24; $a++) { ?>
									<option  <?php echo $start_hour == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
										<?php echo $a ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-6">
							<label>&nbsp;</label>
							<select class="form-control minuto_inicio"  name="minuto_inicio[<?php echo $edicao ?>]" >
								<?php for ($a=0; $a < 60; $a++) { ?>
									<option <?php echo $start_minute == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
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
							<label class="w-100">Final: <input type="text" class="form-control data_final datepicker" name="data_final[<?php echo $edicao ?>]" placeholder="data" value="<?php echo isset($end_date) ? $end_date : date('d/m/Y', strtotime("+1 year")) ?>"></label>
						</div>
						<div class="col-6">
							<label>Horário: </label>
							<select class="form-control hora_final"  name="hora_final[<?php echo $edicao ?>]" >
								<?php for ($a=0; $a < 24; $a++) { ?>
									<option <?php echo $end_hour == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
										<?php echo $a ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-6">
							<label>&nbsp;</label>
							<select class="form-control minuto_final"  name="minuto_final[<?php echo $edicao ?>]" >
								<?php for ($a=0; $a < 60; $a++) { ?>
									<option <?php echo $end_minute == $a ? "selected='true'" : "" ?> value="<?php echo $a ?>">
										<?php echo str_pad($a, 2, "0", STR_PAD_LEFT); ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>					
				</div>
				<div class="col-12 text-left px-3 py-3">
					<label class="w-100">Link: <input type="text" class="form-control link w-100" name="link[<?php echo $edicao ?>]" placeholder="URL de destino" value="<?php echo isset($link) ? $link : "#" ?>"></label>				
				</div>
			</div>
		</div>
		<div class="col-12 col-md-5 border items">
			<?php
			if (isset($banner_id)) {
			?>
				<div class="itemTemp row mb-4 py-3 position-relative">
					<div class="col-12">
						<img src="<?php echo $b->image   ?>" class="img-fluid" style="">
						<input class="banner" name="banners_atual[<?php echo $edicao ?>]" type="hidden" value="<?php echo $b->image   ?>">
						
						<div class="position-absolute btn btn-danger editarItem">Apagar Imagem</div>
					</div>
				</div>
			<?php
			} else {
			?>
				<div class="item row mb-4 py-3"></div>
			<?php
			}
			?>
		</div>
	</div>
</div>