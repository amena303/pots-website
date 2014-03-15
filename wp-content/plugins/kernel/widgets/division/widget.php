<?php
	/**
	 * Adds Division_Widget widget.
	 */
	class Division_Widget extends WP_Widget {

		public static $SLUG = "";
		public static $ID = "";
		public static $PATH = "";
		public static $URL = "";
		public static $PLUGIN_SLUG = "";
		public static $PLUGIN_URL = "";
		public static $PLUGIN_PATH = "";

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			self::$SLUG = "division";
			self::$ID = self::$SLUG."-bloque";
			self::$PATH = plugin_dir_path( __FILE__ );
			self::$URL = plugin_dir_url( __FILE__ );

			self::$PLUGIN_SLUG = PLUGIN_SLUG;
			self::$PLUGIN_URL = PLUGIN_URL;
			self::$PLUGIN_PATH = PLUGIN_PATH;

			parent::__construct(
				'division', // Base ID
				'Division', // Name
				array( 'description' => __( 'A Division Widget', 'text_domain' ), ) // Args
			);

			//-- Scripts
			add_action( 'wp_enqueue_scripts', array($this, 'scripts') );
			//-- Styles
			add_action( 'wp_enqueue_scripts', array($this, 'styles') );
			//-- Scripts Admin
			add_action( 'admin_enqueue_scripts', array($this, 'scripts_ADMIN') );
			//-- Styles Admin
			add_action( 'admin_enqueue_scripts', array($this, 'styles_ADMIN') );
		}

		//-- Setup Default(admin, user) Init
		public function setupDefInit() {
		}

		//-- Setup Admin Init
		public function setupAdmInit() {
		}

		//-- Styles ADMIN
		public function styles_ADMIN() {
			if(is_admin()):

				//-----
				//Generar Less
				//-----
				try{
					if(!class_exists('lessc')):
						throw new Exception('<br><br>¡La clase lessc no ha sido encontrada! #LULZIES<br><br><br>');
					endif;
					//$less = new lessc(self::$PLUGIN_PATH.'css-admin/widgets/'.self::$SLUG.'/style.less');
					//file_put_contents(self::$PLUGIN_PATH.'css-admin/widgets/'.self::$SLUG.'/style.css', $less->parse());
				}
				catch( Exception $e ) {
					echo $e->getMessage();
				}

				//-----
				//Register
				//-----
				//Styles
				if( !wp_style_is(self::$SLUG.'-admin.style', 'registered') )
					wp_register_style(self::$SLUG.'-admin.style', self::$PLUGIN_URL.'css-admin/widgets/'.self::$SLUG.'/style.css');

				if( !wp_style_is('bootstrapcssWP', 'registered') )
					wp_register_style('bootstrapcssWP', self::$PLUGIN_URL.'css-admin/bootstrap/bootstrap.css');

				if( !wp_style_is('bootstrapcssWP-fixes', 'registered') )
					wp_register_style('bootstrapcssWP-fixes', self::$PLUGIN_URL.'css-admin/bootstrap/bootstrap-fixes.css');

				//-----
				//Encolar
				//-----
				//Styles
				if(!wp_style_is(self::$SLUG.'-admin.style', 'queue'))
					wp_enqueue_style(self::$SLUG.'-admin.style');

				if(!wp_style_is('bootstrapcssWP', 'queue'))
					wp_enqueue_style('bootstrapcssWP');

				if(!wp_style_is('bootstrapcssWP-fixes', 'queue'))
					wp_enqueue_style('bootstrapcssWP-fixes');
			endif;
		}

		//-- Scripts ADMIN
		public function scripts_ADMIN() {
			if(is_admin()):
				//-----
				//Register
				//-----
	//			if(!wp_script_is('tiny_mce', 'registered'))
	//				wp_register_script('tiny_mce', self::$PLUGIN_URL.'/js-admin/form/script.js');

				if(!wp_script_is(self::$SLUG.'-admin.script', 'registered'))
					wp_register_script(self::$SLUG.'-admin.script', self::$PLUGIN_URL.'js-admin/widgets/'.self::$SLUG.'/script.js');

				if(!wp_script_is('bootstrapjs', 'registered'))
					wp_register_script('bootstrapjs', self::$PLUGIN_URL.'js/bootstrap/bootstrap.js');

				//-----
				//Encolar
				//-----
				//Scripts
				if(!wp_script_is('tiny_mce', 'queue'))
					wp_enqueue_script('tiny_mce');

				if(!wp_script_is(self::$SLUG.'-admin.script', 'queue'))
					wp_enqueue_script(self::$SLUG.'-admin.script');

				if(!wp_script_is('bootstrapjs', 'queue'))
					wp_enqueue_script('bootstrapjs');
			endif;
		}

		//-- Styles
		public function styles() {
			if(!is_admin()):
				//var_dump(get_declared_classes());
				try {
					if(!class_exists('lessc') ):
						throw new Exception('<br><br>¡La clase lessc no ha sido encontrada! #LULZIES<br><br><br>');
					endif;
					//$less = new lessc(self::$PLUGIN_PATH.'css/widgets/'.self::$SLUG.'/style.less');
					//file_put_contents(self::$PLUGIN_PATH.'css/widgets/'.self::$SLUG.'/style.css', $less->parse());
				}
				catch( Exception $e ) {
					echo $e->getMessage();
				}

				//-----------------
				//Registrar
				//-----------------
				//Styles
				if( !wp_style_is(self::$SLUG.'.style', 'registered') )
					wp_register_style(self::$SLUG.'.style', self::$PLUGIN_URL.'css/widgets/'.self::$SLUG.'/style.css');

				//-----------------
				//Encolar
				//-----------------
				//Styles
				if(!wp_style_is(self::$SLUG.'.style', 'queue'))
					wp_enqueue_style(self::$SLUG.'.style');
			endif;
			//Aquí pasó algo raro LOL
		}

		//-- Scripts
		public function scripts() {
			if(!is_admin()):
				//-----------------
				//Registrar
				//-----------------
				//Scripts
//				if(!wp_script_is('jquery', 'registered'))
//					//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', array(), '1.7.2', false);
//					wp_register_script('jquery', self::$PLUGIN_URL.'js/jquery.js', array(), '1.7.2', true);

				if(!wp_script_is(self::$SLUG.'.script', 'registered'))
					wp_register_script(self::$SLUG.'.script', self::$PLUGIN_URL.'js/widgets/'.self::$SLUG.'/script.js', array( 'jquery' ), '1', true);

				//-----------------
				//Agregar
				//-----------------
				//Scripts
//				if(!wp_script_is('jquery', 'queue'))
//					wp_enqueue_script('jquery');

				if(!wp_script_is(self::$SLUG.'.script', 'queue'))
					wp_enqueue_script(self::$SLUG.'.script');
			endif;
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			global $post;
			extract( $args );

			$sel_title = $instance['title'];
			echo $before_widget;
			//if ( ! empty( $sel_title ) ):
				//echo $before_title;
					//echo $sel_title;
				//echo $after_title;
			//endif;
			//echo "<div class=\"division\"></div>";
			?>
			<?php
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			//var_dump($instance);
			//-- Opcion
			if ( isset( $instance[ 'title' ] ) ):
				$title = $instance[ 'title' ];
			else:
				$title = __( 'Division', 'text_domain' );
			endif;
			$sel_title = esc_attr( $title );
			?>

			<div class="bootstrap-wpadmin ">

				<div class="widget_admin_division">
					<div class="form-horizontal">
						<div class="control-group">
							<div class="control-label">
								<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titulo:' ); ?>&nbsp;</label>
							</div>
							<div class="controls">
								<input class="" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $sel_title ); ?>" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<p>
				<br>
			</p>
			<?php
		}

	} // class Division_Widget

	add_action( 'widgets_init', create_function( '', 'register_widget( "Division_Widget" );' ) );
?>
