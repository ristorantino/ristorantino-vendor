<div class="col-md-8">
	<?php if ( !$this->Session->check('Auth.User')){ ?>
	<h3>Registrese para ingresar al sistema</h3>
	<h1>¡Punto de Venta Web, y GRATUITO!</h1>

	<div class="col-md-4 col-md-offset-4">
		<hr />
	<?php echo $this->Html->link('Registrate', array('plugin'=> 'users','controller'=>'users', 'action'=>'register'), array('class'=>'btn btn-lg btn-success btn-block')) ?>
	</div>
	<?php } else { ?>
	<h1>Novedades PaxaPos</h1>


	<a class="twitter-timeline" href="https://twitter.com/PaxaPos" data-widget-id="636390749106511872">Tweets  @PaxaPos.</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


	<?php } ?>
</div>


<div class="col-md-4 login">
	<div class="row">

		<div class="col-md-12">
			<?php 
			if ( !$this->Session->check('Auth.User')){
				echo $this->element('Users.boxlogin');			
		} else {		
		 ?>
			<h3>&nbsp;</h3>
			<?php echo $this->Html->link(__('Crear Nuevo Comercio'), array('plugin'=>'mt_sites', 'controller'=>'sites', 'action'=>'install'), array('class'=>'btn btn-success btn-lg center')); ?>

			<h1>Mis Comercios</h1>
			
			<div class="list-group">
				<?php App::uses('MtSites', 'MtSites.MtSites'); ?>
				<?php if ( $this->Session->check('Auth.User.Site') ): ?>
					<?php foreach ( $this->Session->read('Auth.User.Site') as $s ):
					?>
						<div class="list-group-item" style="font-size: 15pt;">
							
							<?php echo  $this->Html->link( $s['name'] , array( 'tenant' => $s['alias'], 'plugin'=>'risto' ,'controller' => 'pages', 'action' => 'display', 'dashboard' ), array('class'=>'' ));?>

	                        <?php 
	                        /*
	                        echo $this->Form->postLink("X", array( 'tenant' => false, 'plugin'=>'install' ,'controller' => 'site_setup', 'action' => 'deletesite/'.$s['alias']), array(
	                        		'confirm' => 'Are you sure want to delete site named '.$s['name'].'?',
	                        		'class'=>'btn btn-danger btn-xs pull-right',
	                        		'title' => __("Eliminar")
	                        		));
							*/
	                        		 ?>
						</div>
					<?php endforeach; ?>
            	<?php endif; ?>
            </div>
		<?php } ?>
		</div>
	</div>
</div>