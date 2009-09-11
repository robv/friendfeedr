<?php 
	class FriendFeedr extends Modules {
	
			static function __install()
			{
				$config = Config::current();
				$config->set('friendfeedr_username', 'thisisrobv', true);
				$config->set('friendfeedr_wrapper', '<h2>FriendFeed</h2><p>{feed}</p>', true);
			}
		
			static function __uninstall($confirm)
			{
				if ($confirm) {
					$config = Config::current();
					$config->remove('friendfeedr_username');
				}
			}
		
		    public function settings_nav($navs) {
				if (Visitor::current()->group->can("change_settings"))
					$navs["friendfeedr_settings"] = array("title" => __("FriendFeed", "friendfeedr"));

		        return $navs;
		    }
		
		    public function admin_friendfeedr_settings($admin) {

		        if (empty($_POST))
					return $admin->display("friendfeedr_settings");
		
		        $config = Config::current();
		        if ($config->set("friendfeedr_username", $_POST['friendfeedr_username']) && $config->set("friendfeedr_wrapper", $_POST['friendfeedr_wrapper']))
		            Flash::notice(__("Settings updated."), "/admin/?action=friendfeedr_settings");
		    }
		
			public function sidebar()
			{
				$config = Config::current();
				$wrapper = explode('{feed}', $config->friendfeedr_wrapper);
		?>
		<?= $wrapper[0]; ?>
		<script type="text/javascript" src="http://friendfeed.com/embed/widget/<?php echo $config->friendfeedr_username; ?>?v=3&amp;num=10&amp;hide_logo=1&amp;hide_comments_likes=1"></script><noscript><a href="http://friendfeed.com/<?php echo $config->friendfeedr_username; ?>"><img alt="View my FriendFeed" style="border:0;" src="http://friendfeed.com/embed/widget/<?php echo $config->friendfeedr_username; ?>?v=3&amp;num=10&amp;hide_logo=1&amp;hide_comments_likes=1&amp;format=png"/></a></noscript>
		<?= $wrapper[1]; ?>

		<?php
			}
		
		}
		$friendfeedr = new FriendFeedr();

?>